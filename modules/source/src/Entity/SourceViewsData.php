<?php

namespace Drupal\source\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Source entities.
 */
class SourceViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['source']['source_bulk_form'] = [
      'title' => $this->t('Gradient operations bulk form'),
      'help' => $this->t('Add a form element that lets you run operations on multiple sources.'),
      'field' => [
        'id' => 'source_bulk_form',
      ],
    ];
    // Additional information for Views integration, such as table joins, can be
    // put here.
    return $data;
  }

}
