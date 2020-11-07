<?php

namespace Drupal\gradient_server\Commands;

use Drush\Commands\DrushCommands;
use Drupal\feeds\Entity\Feed;
use Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Term;
use Drupal\source\Entity\Source;
use Drupal\file\Entity\File;
use Drupal\gradient\Entity\Gradient;

class DemoData extends DrushCommands {

  /**
   * Create some demo content.
   *
   * @command gradient:demo_data:create
   * @aliases gdc
   * @usage gradient:demo_data:create
   */
  public function create() {
    $term1 = Term::create([
      'name' => 'Alternative Media',
      'vid' => 'categories',
      'uid' => 1,
    ]);
    $term1->save();
    $term2 = Term::create([
      'name' => 'Personal Blog',
      'vid' => 'categories',
      'uid' => 1,
    ]);
    $term2->save();
    $term3 = Term::create([
      'name' => 'Regular Media',
      'vid' => 'categories',
      'uid' => 1,
    ]);
    $term3->save();

    file_put_contents('public://logo1.jpg', file_get_contents('https://news.alayham.com/sites/default/files/logo/1538728_751733994851906_2075983683_n.png'));
    $logo1 = File::create(['uri' => 'public://logo1.jpg']);
    $logo1->save();
    $source1=Source::create([
      'type' => 'website',
      'name' => '21 Century Wire',
      'logo' => $logo1,
      'url' => 'http://21stcenturywire.com',
      'categories' => [$term1],
      'user_id' => 1,
    ]);
    $source1->save();
    $feed1 = Feed::create([
      'type' => 'rss',
      'title' => '21st Century Wire',
      'uid' => 1,
      'status' => 1,
      'source' => 'http://21stcenturywire.com/feed',
      'source_entity' => [$source1],
      'uid' => 1,
    ]);
    $feed1->save();

    file_put_contents('public://logo2.jpg', file_get_contents('https://news.alayham.com/sites/default/files/logo/DevNullPhantom160-150x150.jpg'));
    $logo2 = File::create(['uri' => 'public://logo2.jpg']);
    $logo2->save();
    $source2 = Source::create([
      'type' => 'website',
      'name' => 'Dissident Voice',
      'logo' => $logo2,
      'url' => 'http://dissidentvoice.org',
      'categories' => [$term1],
      'user_id' => 1,
    ]);
    $source2->save();
    $feed2 = Feed::create([
      'type' => 'rss',
      'title' => 'Dissident Voice',
      'uid' => 1,
      'status' => 1,
      'source' => 'http://dissidentvoice.org/feed/',
      'source_entity' => [$source2],
      'uid' => 1,
    ]);
    $feed2->save();

    file_put_contents('public://logo3.jpg', file_get_contents('https://i2.wp.com/freemanbeyondthewall.com/wp-content/uploads/2018/05/latest-pic.jpg'));
    $logo3 = File::create(['uri' => 'public://logo3.jpg']);
    $logo3->save();
    $source3 = Source::create([
      'type' => 'website',
      'name' => 'Peter R. Quinones',
      'logo' => $logo3,
      'url' => 'https://freemanbeyondthewall.com',
      'categories' => [$term2],
      'user_id' => 1,
    ]);
    $source3->save();
    $feed3 = Feed::create([
      'type' => 'rss',
      'title' => 'Free Man Beyond the Wall',
      'uid' => 1,
      'status' => 1,
      'source' => 'https://liviucerchez.com/castpod/feed/podcast',
      'source_entity' => [$source3],
      'uid' => 1,
    ]);
    $feed3->save();  
    $feed4 = Feed::create([
      'type' => 'rss',
      'title' => 'Peter R. Quinones website feed',
      'uid' => 1,
      'status' => 1,
      'source' => 'https://freemanbeyondthewall.com/feed',
      'source_entity' => [$source3],
      'uid' => 1,
    ]);
    $feed4->save();  

    file_put_contents('public://logo4.jpg', file_get_contents('https://eliasalias.com/wp-content/uploads/2015/06/James_Corbett.jpg'));
    $logo4 = File::create(['uri' => 'public://logo4.jpg']);
    $logo4->save();
    $source4 = Source::create([
      'type' => 'website',
      'name' => 'The Corbett Report',
      'logo' => $logo4,
      'url' => 'https://corbettreport.com',
      'categories' => [$term2],
      'user_id' => 1,
    ]);
    $source4->save();
    $feed5 = Feed::create([
      'type' => 'rss',
      'title' => 'The corbett report website feed',
      'uid' => 1,
      'status' => 1,
      'source' => 'https://corbettreport.com/feed',
      'source_entity' => [$source4],
      'uid' => 1,
    ]);
    $feed5->save();  

    Gradient::create([
      'type' => 'gradient',
      'name' => 'First Gradient',
      'sources' => [$source1, $source2],
    ])->save();
    Gradient::create([
      'type' => 'gradient',
      'name' => 'Second Gradient',
      'sources' => [$source2, $source3, $source4],
    ])->save();
    Gradient::create([
      'type' => 'gradient',
      'name' => 'Third Gradient',
      'sources' => [$source1, $source4],
    ])->save();
    Gradient::create([
      'type' => 'gradient',
      'name' => 'Fourth Gradient',
      'sources' => [$source1, $source2, $source3, $source4],
    ])->save();
  }
}
