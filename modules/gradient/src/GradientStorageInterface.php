<?php

namespace Drupal\gradient;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface GradientStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Gradient revision IDs for a specific Gradient.
   *
   * @param \Drupal\gradient\Entity\GradientInterface $entity
   *   The Gradient entity.
   *
   * @return int[]
   *   Gradient revision IDs (in ascending order).
   */
  public function revisionIds(GradientInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Gradient author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Gradient revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

}
