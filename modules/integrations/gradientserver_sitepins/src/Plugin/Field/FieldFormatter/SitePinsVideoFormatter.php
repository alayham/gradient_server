<?php

namespace Drupal\gradientserver_sitepins\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'sitepins_image' formatter.
 *
 * @FieldFormatter(
 *   id = "sitepins_video",
 *   label = @Translation("Sitepins Video Formatter"),
 *   field_types = {
 *     "string"
 *   }
 * )
 */
class SitePinsVideoFormatter extends FormatterBase {
  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = array();
  
    foreach ($items as $delta => $item) {
      $url = $item->value;
      $elements[$delta] = array(
        '#theme' => 'sitepins_video',
        '#url' => $url,
      );
    }
  
    return $elements;
  }

}
