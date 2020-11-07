<?php

namespace Drupal\gradient\Form;

use Drupal\Core\Entity\Form\DeleteMultipleForm as EntityDeleteMultipleForm;
use Drupal\Core\Url;

/**
 * Provides a gradient deletion confirmation form.
 *
 * @internal
 */
class GradientDeleteMultiple extends EntityDeleteMultipleForm {

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('system.admin_content');
  }

  /**
   * {@inheritdoc}
   */
  protected function getDeletedMessage($count) {
    return $this->formatPlural($count, 'Deleted @count gradients.', 'Deleted @count gradients.');
  }

  /**
   * {@inheritdoc}
   */
  protected function getInaccessibleMessage($count) {
    return $this->formatPlural($count, "@count gradients has not been deleted because you do not have the necessary permissions.", "@count gradients have not been deleted because you do not have the necessary permissions.");
  }

}
