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

    $data['gradient']['gradient_bulk_form'] = [
      'title' => $this->t('Gradient operations bulk form'),
      'help' => $this->t('Add a form element that lets you run operations on multiple gradients.'),
      'field' => [
        'id' => 'gradient_bulk_form',
      ],
    ];

    // Additional information for Views integration, such as table joins, can be
    // put here.
    return $data;
  }

}
