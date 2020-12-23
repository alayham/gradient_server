<?php

namespace Drupal\gradientserver_sitepins\Commands;

use Drush\Commands\DrushCommands;
use Drupal\feeds\Entity\Feed;
use Drupal\file\Entity\File;
use Drupal\source\Entity\Source;
use Drupal\node\Entity\Node;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\gradientserver_sitepins\SitePinsHelper;

/**
 * Defines Drush commands for the Gradientserver_sitepins.
 */
class SitePins extends DrushCommands {

  /**
   * Import SitePins.net Content.
   *
   * @command gradientserver:sitepins:import
   *
   * @usage drush gradientserver:sitepins:import
   *   Imports all sitepins content.
   *
   * @aliases gspc
   */
  public function import() {

    file_put_contents('public://sitepins.png', file_get_contents(__DIR__ . '/../../images/sitepins.png'));
    $logo = File::create(['uri' => 'public://sitepins.png']);
    $source = Source::create([
      'type' => 'website',
      'name' => 'SitePins.net',
      'logo' => $logo,
      'url' => 'http://sitepins.net',
      'user_id' => 1,
      'status' => 1,
    ]);
    $source->save();
    $operations = [];
    foreach(SitePinsHelper::COLLECTIONS as $id => $name) {
      $feeds[$id] = Feed::create([
        'type' => 'sitepins_feed',
        'title' => $name,
        'status' => 1,
        'source' => 'http://sitepins.net/Collection/' . $id,
        'source_entity' => $source,
        'uid' => 1,
      ]);
      $feeds[$id]->save();
      $operations[] = [
        [__CLASS__, 'importCollection'],
        [$feeds[$id]],
      ];

    }
    $batch = [
      'title' => 'Updating Sitepins.net',
      'operations' => $operations,
      'finished' => [__CLASS__, 'finished'],
    ];
    batch_set($batch);
    drush_backend_batch_process();
  }

  /**
   * Imports a sitepins feed through the batch api.
   * 
   * @param \Drupal\feeds\Entity\Feed $feed
   *   The feed entity.
   * @param array $context
   *   The batch context, called by reference.
   * 
   * @return string
   *   A batch operation result.
   */
  public static function importCollection(Feed $feed, &$context) {
    if(empty($context['sandbox'])){
      $context['sandbox']['page'] = 0;
    }
    if ($context['sandbox']['page'] === 1500) {
      // Prevent infinite loops.
      $context['finished'] = 1;
      return new TranslatableMarkup('Reached import limit for feed @feed', [
        '@feed' => $feed->label(),
      ]);
    }
    $context['finished'] = 0;
    $context['sandbox']['page']++;
    $html = SitePinsHelper::getHtml($feed, $context['sandbox']['page']);
    if (empty($html)) {
      $context['finished'] = 1;
      return new TranslatableMarkup('No more items found in feed @feed', [
        '@feed' => $feed->label(),
      ]);
    }
    $fields = [
      'type' => 'sitepins_item',
      'status' => 1,
      'promote' => 0,
      'uid' => 1,
      'feed_entity' => [$feed],
    ];
    $html = '<html>' . $html . '</html>';
    $items = SitePinsHelper::parseHtml($html);
    foreach($items as $item) {
      $item_fields = array_merge ($fields, $item, [
        'feeds_item' => [
          'target_id' => $feed->id(),
          'guid' => $item['guid'],
          'item_url' => $item['sitepins_video_url'],
        ],
        'link' => [
          'uri' => $item['sitepins_video_url'],
          'title' => $item['title']
        ],
      ]);
      Node::create($item_fields)->save();
    }
    return new TranslatableMarkup('Imported @count items from page @page in feed @feed', [
      '@count' => count($items),
      '@page' => $context['sandbox']['page'],
      '@feed' => $feed->label(),
    ]);
  }

  /**
   * Finish a batch.
   * 
   * @return string
   *   the batch result.
   */
  public function finished() {

  }

}
