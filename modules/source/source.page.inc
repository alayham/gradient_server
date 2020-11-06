<?php

/**
 * @file
 * Contains source.page.inc.
 *
 * Page callback for Source entities.
 */

use Drupal\Core\Render\Element;

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
    'canonical' => $source->toUrl(),
  ];
  if ($source->logo->entity) {
    $variables['source']['logo'] = $source->logo->entity->createFileUrl();
  }
}
