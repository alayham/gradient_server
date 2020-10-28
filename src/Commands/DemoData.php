<?php

namespace Drupal\gradient_server\Commands;

use Drush\Commands\DrushCommands;
use Drupal\feeds\Entity\Feed;
use Drupal\node\Entity\Node;

class DemoData extends DrushCommands {

  /**
   * Create some demo content.
   *
   * @command gradient:demo_data:create
   * @aliases gdc
   * @usage gradient:demo_data:create
   */
  public function create() {
    $feed1 = Feed::create([
      'type' => 'rss',
      'title' => 'Alayham Saleh aggregator',
      'uid' => 1,
      'status' => 1,
      'source' => 'https://news.alayham.com/feed',
    ]);
    $feed1->save();

    $feed2 = Feed::create([
      'type' => 'rss',
      'title' => 'Alayham Saleh aggregator (Local links)',
      'uid' => 1,
      'status' => 1,
      'source' => 'https://news.alayham.com/feed/local',
    ]);
    $feed2->save();

    $gradient1 = Node::create([
      'type' => 'gradient',
      'uid' => 1,
      'title' => 'First Gradient',
      'body' => 'This is a demo gradient',
      'feeds' => [
        $feed1
      ]
    ]);
    $gradient1->save();
  }
}
