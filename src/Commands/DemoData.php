<?php

namespace Drupal\gradient_server\Commands;

use Drush\Commands\DrushCommands;
use Drupal\feeds\Entity\Feed;
use Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Term;
use Drupal\source\Entity\Source;
use Drupal\file\Entity\File;
use Drupal\gradient\Entity\Gradient;
use Drupal\user\Entity\User;
use Drupal\user\Entity\Role;

class DemoData extends DrushCommands {

  /**
   * Create some demo content.
   *
   * @command gradient:demo_data:create
   * @aliases gdc
   * @usage gradient:demo_data:create
   */
  public function createDemoData() {
    $term1 = Term::create([
      'name' => 'Alternative Media',
      'vid' => 'categories',
      'uid' => $user2,
      'status' => 1,
    ]);
    $term1->save();
    $term2 = Term::create([
      'name' => 'Personal Blog',
      'vid' => 'categories',
      'uid' => $user2,
      'status' => 1,
    ]);
    $term2->save();
    $term3 = Term::create([
      'name' => 'Regular Media',
      'vid' => 'categories',
      'uid' => $user2,
      'status' => 1,
    ]);
    $term3->save();

    $role1 = Role::load('source_user');
    $role2 = Role::load('gradient_user');
    $user1 = User::create([
      'name' => 'Source user',
      'email' => 'user1@example.com',
      'password' => user_password(25),
      'status' => 1,
      'roles' => [$role1],
    ]);
    $user1->save();

    $user2 = User::create([
      'name' => 'Source and Gradient User',
      'email' => 'user2@example.com',
      'password' => user_password(25),
      'status' => 1,
      'roles' => [$role1, $role2],
    ]);
    $user2->save();

    $user3 = User::create([
      'name' => 'Gradient user',
      'email' => 'user3@example.com',
      'password' => user_password(25),
      'status' => 1,
      'roles' => [$role2],
    ]);
    $user3->save();

    $user3 = User::create([
      'name' => 'normal user',
      'email' => 'user4@example.com',
      'password' => user_password(25),
      'status' => 1,
      'roles' => [],
    ]);
    $user3->save();

    file_put_contents('public://logo1.jpg', file_get_contents('https://news.alayham.com/sites/default/files/logo/1538728_751733994851906_2075983683_n.png'));
    $logo1 = File::create(['uri' => 'public://logo1.jpg']);
    $logo1->save();
    $source1=Source::create([
      'type' => 'website',
      'name' => '21 Century Wire',
      'logo' => $logo1,
      'url' => 'http://21stcenturywire.com',
      'categories' => [$term1],
      'user_id' => $user1,
      'status' => 1,
    ]);
    $source1->save();
    $feed1 = Feed::create([
      'type' => 'rss',
      'title' => '21st Century Wire',
      'uid' => $user2,
      'status' => 1,
      'source' => 'http://21stcenturywire.com/feed',
      'source_entity' => [$source1],
      'uid' => $user1,
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
      'user_id' => $user1,
      'status' => 1,
    ]);
    $source2->save();
    $feed2 = Feed::create([
      'type' => 'rss',
      'title' => 'Dissident Voice',
      'uid' => $user2,
      'status' => 1,
      'source' => 'http://dissidentvoice.org/feed/',
      'source_entity' => [$source2],
      'uid' => $user1,
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
      'user_id' => $user1,
      'status' => 1,
    ]);
    $source3->save();
    $feed3 = Feed::create([
      'type' => 'rss',
      'title' => 'Free Man Beyond the Wall',
      'uid' => $user2,
      'status' => 1,
      'source' => 'https://liviucerchez.com/castpod/feed/podcast',
      'source_entity' => [$source3],
      'uid' => $user1,
    ]);
    $feed3->save();  
    $feed4 = Feed::create([
      'type' => 'rss',
      'title' => 'Peter R. Quinones website feed',
      'uid' => $user2,
      'status' => 1,
      'source' => 'https://freemanbeyondthewall.com/feed',
      'source_entity' => [$source3],
      'uid' => $user1,
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
      'user_id' => $user2,
      'status' => 1,
    ]);
    $source4->save();
    $feed5 = Feed::create([
      'type' => 'rss',
      'title' => 'The corbett report website feed',
      'uid' => $user2,
      'status' => 1,
      'source' => 'https://corbettreport.com/feed',
      'source_entity' => [$source4],
      'uid' => $user2,
    ]);
    $feed5->save();  

    file_put_contents('public://logo5.jpg', file_get_contents('https://www.freedomsphoenix.com/Uploads/Graphics/001-0602071125-2009-22-x-29-Banner-copy.jpg'));
    $logo5 = File::create(['uri' => 'public://logo5.jpg']);
    $logo5->save();
    $source5 = Source::create([
      'type' => 'website',
      'name' => 'Freedom\'s Phoenix',
      'logo' => $logo5,
      'url' => 'https://www.freedomsphoenix.com',
      'categories' => [$term1],
      'user_id' => $user2,
      'status' => 1,
    ]);
    $source5->save();

    $feed6 = Feed::create([
      'type' => 'rss',
      'title' => 'Freedom\'s Phoenix Feature Articles',
      'uid' => $user2,
      'status' => 1,
      'source' => 'https://www.freedomsphoenix.com/RSS/RSS-Feed.xml?EdNo=001&Page=Art',
      'source_entity' => [$source5],
      'uid' => $user2,
    ]);
    $feed6->save();  
    $feed7 = Feed::create([
      'type' => 'rss',
      'title' => 'Freedom\'s Phoenix Editorials',
      'uid' => $user2,
      'status' => 1,
      'source' => 'https://www.freedomsphoenix.com/RSS/RSS-Feed.xml?EdNo=001&Page=Col',
      'source_entity' => [$source5],
      'uid' => $user2,
    ]);
    $feed7->save();  
    $feed8 = Feed::create([
      'type' => 'rss',
      'title' => 'Freedom\'s Phoenix Newsletter Headlines',
      'uid' => $user2,
      'status' => 1,
      'source' => 'https://www.freedomsphoenix.com/RSS/Top-News-Feed.xml',
      'source_entity' => [$source5],
      'uid' => $user2,
    ]);
    $feed8->save();  
    $feed9 = Feed::create([
      'type' => 'rss',
      'title' => 'Freedom\'s Phoenix Radio/TV Show Archives',
      'uid' => $user2,
      'status' => 1,
      'source' => 'https://www.freedomsphoenix.com/RSS/RSS-Feed.xml?EdNo=001&Page=Med',
      'source_entity' => [$source5],
      'uid' => $user2,
    ]);
    $feed9->save();  

    file_put_contents('public://logo6.jpg', file_get_contents('https://pbs.twimg.com/profile_images/1226913212/mm_star_logo_400x400.jpg'));
    $logo6 = File::create(['uri' => 'public://logo6.jpg']);
    $logo6->save();
    $source6 = Source::create([
      'type' => 'website',
      'name' => 'Media Monarchy',
      'logo' => $logo6,
      'url' => 'https://mediamonarchy.com/',
      'categories' => [$term2],
      'user_id' => $user2,
      'status' => 1,
    ]);
    $source6->save();
    $feed10 = Feed::create([
      'type' => 'rss',
      'title' => 'Media Monarchy feed',
      'uid' => $user2,
      'status' => 1,
      'source' => 'https://mediamonarchy.com/feed/',
      'source_entity' => [$source6],
      'uid' => $user2,
    ]);
    $feed10->save();  

    file_put_contents('public://logo7.jpg', file_get_contents('https://pbs.twimg.com/profile_images/3539908374/6f1209cbd6791a478e65d8d03e32be8d_400x400.jpeg'));
    $logo7 = File::create(['uri' => 'public://logo7.jpg']);
    $logo7->save();
    $source7 = Source::create([
      'type' => 'website',
      'name' => 'Ron Paul Institute',
      'logo' => $logo7,
      'url' => 'http://www.ronpaulinstitute.org',
      'categories' => [$term1],
      'user_id' => $user2,
      'status' => 1,
    ]);
    $source7->save();
    $feed11 = Feed::create([
      'type' => 'rss',
      'title' => 'RPI Peace and Prosperity',
      'uid' => $user2,
      'status' => 1,
      'source' => 'http://www.ronpaulinstitute.org/archives/peace-and-prosperity/rss.aspx?blogid=1',
      'source_entity' => [$source7],
      'uid' => $user2,
    ]);
    $feed11->save();  
    $feed12 = Feed::create([
      'type' => 'rss',
      'title' => 'RPI Congress Alert',
      'uid' => $user2,
      'status' => 1,
      'source' => 'http://www.ronpaulinstitute.org/archives/congress-alert/rss.aspx?blogid=2',
      'source_entity' => [$source7],
      'uid' => $user2,
    ]);
    $feed12->save();  
    $feed13 = Feed::create([
      'type' => 'rss',
      'title' => 'RPI Features Articles',
      'uid' => $user2,
      'status' => 1,
      'source' => 'http://www.ronpaulinstitute.org/archives/featured-articles/rss.aspx?blogid=3',
      'source_entity' => [$source7],
      'uid' => $user2,
    ]);
    $feed13->save();  
    $feed14 = Feed::create([
      'type' => 'rss',
      'title' => 'RPI NeoCon Watch',
      'uid' => $user2,
      'status' => 1,
      'source' => 'http://www.ronpaulinstitute.org/archives/neocon-watch/rss.aspx?blogid=4',
      'source_entity' => [$source7],
      'uid' => $user2,
    ]);
    $feed14->save();  

    file_put_contents('public://logo8.jpg', file_get_contents('https://pbs.twimg.com/profile_images/952953971131469827/y-S5os89_400x400.jpg'));
    $logo8 = File::create(['uri' => 'public://logo8.jpg']);
    $logo8->save();
    $source8 = Source::create([
      'type' => 'website',
      'name' => 'Off Guardian',
      'logo' => $logo8,
      'url' => 'https://off-guardian.org/',
      'categories' => [$term1],
      'user_id' => $user2,
      'status' => 1,
    ]);
    $source8->save();
    $feed15 = Feed::create([
      'type' => 'rss',
      'title' => 'Off Guardian Feed',
      'uid' => $user2,
      'status' => 1,
      'source' => 'https://off-guardian.org/feed',
      'source_entity' => [$source8],
      'uid' => $user2,
    ]);
    $feed15->save();  

    Gradient::create([
      'type' => 'gradient',
      'name' => 'First Gradient',
      'sources' => [$source1, $source2, $source5],
      'user_id' => $user2,
      'status' => $user2,
    ])->save();
    Gradient::create([
      'type' => 'gradient',
      'name' => 'Second Gradient',
      'sources' => [$source2, $source3, $source4, $source6],
      'user_id' => $user2,
      'status' => $user2,
    ])->save();
    Gradient::create([
      'type' => 'gradient',
      'name' => 'Third Gradient',
      'sources' => [$source1, $source4, $source6, $source7, $source8],
      'user_id' => $user2,
      'status' => $user3,
    ])->save();
    Gradient::create([
      'type' => 'gradient',
      'name' => 'Fourth Gradient',
      'sources' => [$source1, $source2, $source3, $source4, $source5, $source8],
      'user_id' => $user2,
      'status' => $user3,
    ])->save();
  }

  /**
   * Empty db and remove all content.
   *
   * @command gradient:demo_data:remove
   * @aliases gdr
   * @usage gradient:demo_data:remove
   */
  public function removeAllContent() {
    $tables = [
      'taxonomy_index', 'Taxonomy_term_data', 'taxonomy_term_field_data', 'taxonomy_term_field_revision', 'taxonomy_term_revision', 'taxonomy_term_revision__parent', 'taxonomy_term__parent',
      'source', 'source_field_data', 'source_revision', 'source_field_revision', 'source_revision__categories', 'source_revision__logo', 'source_revision__url', 'source__categories', 'source__logo', 'source__url',
      'node', 'node_field_data', 'node_field_revision', 'node_revision', 'node_revision__body', 'node_revision__feeds_item', 'node_revision__feed_entity', 'node_revision__layout_builder__layout', 'node_revision__link', 'node_revision__tags',
      'node__body', 'node__feeds_item', 'node__feed_entity', 'node__layout_builder__layout', 'node__link', 'node__tags',
      'gradient', 'gradient_revision', 'gradient_revision__sources', 'gradient__sources',
      'user__roles'
    ];

    foreach ($tables as $table) {
      \Drupal::database()->query("TRUNCATE $table");
    }
    \Drupal::database()->query('DELETE FROM users_field_data WHERE uid > 1');
    \Drupal::database()->query('DELETE FROM users WHERE uid > 1');
  }
  
}
