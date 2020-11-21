<?php

namespace Drupal\source\Plugin\views\field;

use Drupal\views\Plugin\views\field\BulkForm;

/**
 * Defines a node operations bulk form element.
 *
 * @ViewsField("source_bulk_form")
 */
class SourceBulkForm extends BulkForm {

  /**
   * {@inheritdoc}
   */
  protected function emptySelectedMessage() {
    return $this->t('No sources selected.');
  }

  /**
   * {@inheritdoc}
   */
  protected function getBulkOptions($filtered = TRUE) {
    $options = parent::getBulkOptions($filtered);

    return array_reverse($options, TRUE);
  }

}
