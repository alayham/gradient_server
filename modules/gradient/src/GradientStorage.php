<?php

namespace Drupal\gradient;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\gradient\Entity\GradientInterface;

/**
 * Defines the storage handler class for Gradient entities.
 *
 * This extends the base storage class, adding required special handling for
 * Gradient entities.
 *
 * @ingroup gradient
 */
class GradientStorage extends SqlContentEntityStorage implements GradientStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(GradientInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {gradient_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {gradient_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

}
