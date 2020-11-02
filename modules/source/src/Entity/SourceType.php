<?php

namespace Drupal\source\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Source type entity.
 *
 * @ConfigEntityType(
 *   id = "source_type",
 *   label = @Translation("Source type"),
 *   label_collection = @Translation("Source types"),
 *   label_singular = @Translation("source type"),
 *   label_plural = @Translation("source types"),
 *   label_count = @PluralTranslation(
 *     singular = "@count source type",
 *     plural = "@count source types",
 *   ),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\source\SourceTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\source\Form\SourceTypeForm",
 *       "edit" = "Drupal\source\Form\SourceTypeForm",
 *       "delete" = "Drupal\source\Form\SourceTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\source\SourceTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "source_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "source",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/source_type/{source_type}",
 *     "add-form" = "/admin/structure/source_type/add",
 *     "edit-form" = "/admin/structure/source_type/{source_type}/edit",
 *     "delete-form" = "/admin/structure/source_type/{source_type}/delete",
 *     "collection" = "/admin/structure/source_type"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "uuid"
 *   }
 * )
 */
class SourceType extends ConfigEntityBundleBase implements SourceTypeInterface {

  /**
   * The Source type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Source type label.
   *
   * @var string
   */
  protected $label;

}
