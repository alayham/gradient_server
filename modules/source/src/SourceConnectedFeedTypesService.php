<?php

namespace Drupal\source;

use Drupal\Core\Entity\EntityTypeBundleInfoInterface;
use Drupal\Core\Entity\EntityFieldManagerInterface;

/**
 * The Source Connected Feed Types service.
 */
class SourceConnectedFeedTypesService {

  protected $infoService;

  protected $fieldManager;

  protected $types = NULL;

  /**
   * Created a new instance of the service.
   * 
   * @var \Drupal\Core\Entity\EntityTypeBundleInfoInterface  $entity_type_bundle_info
   *   The Entity Type Bundle Indo sericece.-white
   * @var \Drupal\Core\Entity\EntityFieldManagerInterface $entity_field_manager
   *   The Entity Field Manager service.
   */
  public function __construct(EntityTypeBundleInfoInterface $entity_type_bundle_info, EntityFieldManagerInterface $entity_field_manager) {
    $this->infoService = $entity_type_bundle_info;
    $this->fieldManager = $entity_field_manager;
  }

  /**
   * Gets connected feed types.
   */
  public function getConnectedFeedTypes() {
    if (is_null($this->types)) {
      $this->types = [];
      $types = $this->infoService->getBundleInfo('feeds_feed');
      foreach ($types as $id => $type) {
        $fields = $this->fieldManager->getFieldDefinitions('feeds_feed', $id);
        if (isset($fields['source_entity'])) {
          $this->types[$id] = $type['label'];
        }
      }
    }
    return $this->types;
  }

}
