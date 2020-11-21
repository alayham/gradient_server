<?php

/**
 * @file
 * Contains gradient.page.inc.
 *
 * Page callback for Gradient entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Gradient templates.
 *
 * Default template: gradient.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_gradient(array &$variables) {
  // Fetch Gradient Entity Object.
  $gradient = $variables['elements']['#gradient'];

  $variables['gradient'] = [
    'name' => $gradient->label(),
    'canonical' => $gradient->toUrl()->toString(),
    'feed' => $gradient->toUrl()->toString() . '/feed',
  ];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
