<?php

namespace Drupal\gradient\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Gradient entities.
 *
 * @ingroup gradient
 */
interface GradientInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Gradient name.
   *
   * @return string
   *   Name of the Gradient.
   */
  public function getName();

  /**
   * Sets the Gradient name.
   *
   * @param string $name
   *   The Gradient name.
   *
   * @return \Drupal\gradient\Entity\GradientInterface
   *   The called Gradient entity.
   */
  public function setName($name);

  /**
   * Gets the Gradient creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Gradient.
   */
  public function getCreatedTime();

  /**
   * Sets the Gradient creation timestamp.
   *
   * @param int $timestamp
   *   The Gradient creation timestamp.
   *
   * @return \Drupal\gradient\Entity\GradientInterface
   *   The called Gradient entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Gets the Gradient revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Gradient revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\gradient\Entity\GradientInterface
   *   The called Gradient entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Gradient revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Gradient revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\gradient\Entity\GradientInterface
   *   The called Gradient entity.
   */
  public function setRevisionUserId($uid);

}
