<?php

namespace Drupal\source\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Source entities.
 *
 * @ingroup source
 */
interface SourceInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Source name.
   *
   * @return string
   *   Name of the Source.
   */
  public function getName();

  /**
   * Sets the Source name.
   *
   * @param string $name
   *   The Source name.
   *
   * @return \Drupal\source\Entity\SourceInterface
   *   The called Source entity.
   */
  public function setName($name);

  /**
   * Gets the Source creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Source.
   */
  public function getCreatedTime();

  /**
   * Sets the Source creation timestamp.
   *
   * @param int $timestamp
   *   The Source creation timestamp.
   *
   * @return \Drupal\source\Entity\SourceInterface
   *   The called Source entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Gets the Source revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Source revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\source\Entity\SourceInterface
   *   The called Source entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Source revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Source revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\source\Entity\SourceInterface
   *   The called Source entity.
   */
  public function setRevisionUserId($uid);

}
