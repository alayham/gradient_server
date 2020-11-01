<?php

namespace Drupal\source;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\source\Entity\SourceInterface;

/**
 * Defines the storage handler class for Source entities.
 *
 * This extends the base storage class, adding required special handling for
 * Source entities.
 *
 * @ingroup source
 */
interface SourceStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Source revision IDs for a specific Source.
   *
   * @param \Drupal\source\Entity\SourceInterface $entity
   *   The Source entity.
   *
   * @return int[]
   *   Source revision IDs (in ascending order).
   */
  public function revisionIds(SourceInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Source author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Source revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\source\Entity\SourceInterface $entity
   *   The Source entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(SourceInterface $entity);

  /**
   * Unsets the language for all Source with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
