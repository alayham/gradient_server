<?php

namespace Drupal\gradient\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Gradient entities.
 */
class GradientViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.
    return $data;
  }

}
