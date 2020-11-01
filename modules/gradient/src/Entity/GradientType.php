<?php

namespace Drupal\gradient\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Gradient type entity.
 *
 * @ConfigEntityType(
 *   id = "gradient_type",
 *   label = @Translation("Gradient type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\gradient\GradientTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\gradient\Form\GradientTypeForm",
 *       "edit" = "Drupal\gradient\Form\GradientTypeForm",
 *       "delete" = "Drupal\gradient\Form\GradientTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\gradient\GradientTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "gradient_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "gradient",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/gradient_type/{gradient_type}",
 *     "add-form" = "/admin/structure/gradient_type/add",
 *     "edit-form" = "/admin/structure/gradient_type/{gradient_type}/edit",
 *     "delete-form" = "/admin/structure/gradient_type/{gradient_type}/delete",
 *     "collection" = "/admin/structure/gradient_type"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "uuid"
 *   }
 * )
 */
class GradientType extends ConfigEntityBundleBase implements GradientTypeInterface {

  /**
   * The Gradient type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Gradient type label.
   *
   * @var string
   */
  protected $label;

}
