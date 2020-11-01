<?php

namespace Drupal\gradient_server\Commands;

use Drush\Commands\DrushCommands;
use Drupal\feeds\Entity\Feed;
use Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Term;
use Drupal\source\Entity\Source;

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
    $term1->save();
    $source1=Source::create([
      'type' => 'website',
      'name' => '21 Century Wire',
      'url' => ['url' => 'http://21stcenturywire.com'],
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

    $source2 = Source::create([
      'type' => 'website',
      'name' => 'Dissident Voice',
      'url' => ['url' => 'http://dissidentvoice.org'],
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

    $source3 = Source::create([
      'type' => 'website',
      'name' => 'Corbett Report',
      'url' => ['url' => 'http://corbettreport.com'],
      'categories' => [$term2],
      'user_id' => 1,
    ]);
    $source3->save();
    $feed3 = Feed::create([
      'type' => 'rss',
      'title' => 'Corbett Report podcasts',
      'uid' => 1,
      'status' => 1,
      'source' => 'http://feeds.feedburner.com/CorbettreportcomPodcast',
      'source_entity' => [$source3],
      'uid' => 1,
    ]);
    $feed3->save();  
    $feed3 = Feed::create([
      'type' => 'rss',
      'title' => 'Corbett Report articles',
      'uid' => 1,
      'status' => 1,
      'source' => 'http://feeds.feedburner.com/corbettreport_articles',
      'source_entity' => [$source3],
      'uid' => 1,
    ]);
    $feed3->save();  
  }
}
