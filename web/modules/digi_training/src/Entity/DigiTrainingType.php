<?php declare(strict_types = 1);

namespace Drupal\digi_training\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Digi training type configuration entity.
 *
 * @ConfigEntityType(
 *   id = "digi_training_type",
 *   label = @Translation("Digi training type"),
 *   label_collection = @Translation("Digi training types"),
 *   label_singular = @Translation("digi training type"),
 *   label_plural = @Translation("digi trainings types"),
 *   label_count = @PluralTranslation(
 *     singular = "@count digi trainings type",
 *     plural = "@count digi trainings types",
 *   ),
 *   handlers = {
 *     "form" = {
 *       "add" = "Drupal\digi_training\Form\DigiTrainingTypeForm",
 *       "edit" = "Drupal\digi_training\Form\DigiTrainingTypeForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *     "list_builder" = "Drupal\digi_training\DigiTrainingTypeListBuilder",
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   admin_permission = "administer digi_training types",
 *   bundle_of = "digi_training",
 *   config_prefix = "digi_training_type",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *   },
 *   links = {
 *     "add-form" = "/admin/structure/digi_training_types/add",
 *     "edit-form" = "/admin/structure/digi_training_types/manage/{digi_training_type}",
 *     "delete-form" = "/admin/structure/digi_training_types/manage/{digi_training_type}/delete",
 *     "collection" = "/admin/structure/digi_training_types",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "uuid",
 *   },
 * )
 */
final class DigiTrainingType extends ConfigEntityBundleBase {

  /**
   * The machine name of this digi training type.
   */
  protected string $id;

  /**
   * The human-readable name of the digi training type.
   */
  protected string $label;

}
