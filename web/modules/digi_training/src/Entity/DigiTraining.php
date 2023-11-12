<?php declare(strict_types = 1);

namespace Drupal\digi_training\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\digi_training\DigiTrainingInterface;

/**
 * Defines the digi training entity class.
 *
 * @ContentEntityType(
 *   id = "digi_training",
 *   label = @Translation("Digi training"),
 *   label_collection = @Translation("Digi trainings"),
 *   label_singular = @Translation("digi training"),
 *   label_plural = @Translation("digi trainings"),
 *   label_count = @PluralTranslation(
 *     singular = "@count digi trainings",
 *     plural = "@count digi trainings",
 *   ),
 *   bundle_label = @Translation("Digi training type"),
 *   handlers = {
 *     "list_builder" = "Drupal\digi_training\DigiTrainingListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\digi_training\Form\DigiTrainingForm",
 *       "edit" = "Drupal\digi_training\Form\DigiTrainingForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *       "delete-multiple-confirm" = "Drupal\Core\Entity\Form\DeleteMultipleForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "digi_training",
 *   admin_permission = "administer digi_training types",
 *   entity_keys = {
 *     "id" = "id",
 *     "bundle" = "bundle",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *   },
 *   links = {
 *     "collection" = "/admin/content/digi-training",
 *     "add-form" = "/digi-training/add/{digi_training_type}",
 *     "add-page" = "/digi-training/add",
 *     "canonical" = "/digi-training/{digi_training}",
 *     "edit-form" = "/digi-training/{digi_training}/edit",
 *     "delete-form" = "/digi-training/{digi_training}/delete",
 *     "delete-multiple-form" = "/admin/content/digi-training/delete-multiple",
 *   },
 *   bundle_entity_type = "digi_training_type",
 *   field_ui_base_route = "entity.digi_training_type.edit_form",
 * )
 */
final class DigiTraining extends ContentEntityBase implements DigiTrainingInterface {

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type): array {

    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['label'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Label'))
      ->setRequired(TRUE)
      ->setSetting('max_length', 255)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('view', TRUE);

    return $fields;
  }

}
