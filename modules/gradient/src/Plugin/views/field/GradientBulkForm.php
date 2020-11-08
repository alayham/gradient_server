<?php

namespace Drupal\gradient\Plugin\views\field;

use Drupal\views\Plugin\views\field\BulkForm;

/**
 * Defines a node operations bulk form element.
 *
 * @ViewsField("gradient_bulk_form")
 */
class GradientBulkForm extends BulkForm {

  /**
   * {@inheritdoc}
   */
  protected function emptySelectedMessage() {
    return $this->t('No gradients selected.');
  }

  /**
   * {@inheritdoc}
   */
  protected function getBulkOptions($filtered = TRUE) {
    $options = parent::getBulkOptions($filtered);

    return array_reverse($options, true);
  }

}
