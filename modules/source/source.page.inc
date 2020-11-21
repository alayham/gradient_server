<?php

/**
 * @file
 * Contains source.page.inc.
 *
 * Page callback for Source entities.
 */

use Drupal\Core\Render\Element;
use Drupal\Core\Url;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Prepares variables for Source templates.
 *
 * Default template: source.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_source(array &$variables) {
  // Fetch Source Entity Object.
  $source = $variables['elements']['#source'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }

  $variables['source'] = [
    'url' => $source->url->first()->getUrl()->toString(),
    'name' => $source->label(),
    'canonical' => $source->toUrl()->toString(),
    'feed' => $source->toUrl()->toString() . '/feed',
    'buttons' => [],
  ];
  if ($source->logo->entity) {
    $variables['source']['logo'] = $source->logo->entity->createFileUrl();
  }

  if ($source->access('update')) {
    $feed_types = \Drupal::service('source.connected_feed_types')->getConnectedFeedTypes();
    foreach ($feed_types as $id => $label) {
      if (\Drupal::entityTypeManager()->getAccessControlHandler('feeds_feed')->createAccess($id)) {
        $variables['source']['buttons'][] = [
          '#type' => 'link',
          '#attributes' => [
            'class' => ['btn', 'btn-primary'],
          ],
          '#title' => new TranslatableMarkup('Add a new @type', ['@type' => $label]),
          '#url' => URL::fromRoute('source.add_feed', [
            'feed_type' => $id,
            'source' => $source->id(),
          ]),
        ];
      }
    }
  }

}
