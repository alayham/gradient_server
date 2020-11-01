<?php

namespace Drupal\source;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
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
class SourceStorage extends SqlContentEntityStorage implements SourceStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(SourceInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {source_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {source_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(SourceInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {source_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('source_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
