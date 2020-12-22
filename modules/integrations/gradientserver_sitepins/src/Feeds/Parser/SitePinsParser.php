<?php

namespace Drupal\gradientserver_sitepins\Feeds\Parser;

use Drupal\feeds\FeedInterface;
use Drupal\feeds\Plugin\Type\Parser\ParserInterface;
use Drupal\feeds\Plugin\Type\PluginBase;
use Drupal\feeds\Result\FetcherResultInterface;
use Drupal\feeds\StateInterface;
use Drupal\feeds\Result\ParserResult;
use Drupal\gradientserver_sitepins\Feeds\Item\SitePinsItem;
use Drupal\gradientserver_sitepins\SitePinsHelper;

/**
 * Your Class Description.
 *
 * @FeedsParser(
 *   id = "sitepins_parser",
 *   title = @Translation("GradientServer parser for SitePins.net"),
 *   description = @Translation("To be used solely on sitepins.net feed items.")
 * )
 */
class SitePinsParser extends PluginBase implements ParserInterface {

  /**
   * {@inheritdoc}
   */
  public function parse(FeedInterface $feed, FetcherResultInterface $fetcher_result, StateInterface $state) {
    $result = new ParserResult();
    $raw = $fetcher_result->getRaw();
    $items = SitePinsHelper::parseHtml($raw);
    foreach($items as $item_array) {
      $item = new SitePinsItem();
      $item->fromArray($item_array);
      $result->addItem($item);
    }
    return $result;
  }

  /**
   * {@inheritdoc}
   */
  public function getMappingSources() {
    return [
      'guid' => [
        'label' => $this->t('GUID'),
        'description' => $this->t('Unique ID for the Item.'),
      ],
      'sitepins_thumbnail_url' => [
        'label' => $this->t('Thumbnail URL'),
        'description' => $this->t('The URL of the thumbnail of the video'),
      ],
      'sitepins_video_url' => [
        'label' => $this->t('Video URL'),
        'description' => $this->t('The URL of the video'),
      ],
      'title' => [
        'label' => $this->t('Title'),
        'description' => $this->t('The title of the video.'),
      ],
      'created' => [
        'label' => $this->t('PostdDate'),
        'description' => $this->t('The publication date of the video.'),
      ],
      'sitepins_author' => [
        'label' => $this->t('Author'),
        'description' => $this->t('The original author of the video'),
      ],
    ];
  }

}
