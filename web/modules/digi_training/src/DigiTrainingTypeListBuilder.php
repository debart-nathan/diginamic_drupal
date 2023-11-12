<?php declare(strict_types = 1);

namespace Drupal\digi_training;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of digi training type entities.
 *
 * @see \Drupal\digi_training\Entity\DigiTrainingType
 */
final class DigiTrainingTypeListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader(): array {
    $header['label'] = $this->t('Label');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity): array {
    $row['label'] = $entity->label();
    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  public function render(): array {
    $build = parent::render();

    $build['table']['#empty'] = $this->t(
      'No digi training types available. <a href=":link">Add digi training type</a>.',
      [':link' => Url::fromRoute('entity.digi_training_type.add_form')->toString()],
    );

    return $build;
  }

}
