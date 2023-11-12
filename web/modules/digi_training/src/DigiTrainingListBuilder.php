<?php declare(strict_types = 1);

namespace Drupal\digi_training;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

/**
 * Provides a list controller for the digi training entity type.
 */
final class DigiTrainingListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader(): array {
    $header['id'] = $this->t('ID');
    $header['label'] = $this->t('Label');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity): array {
    /** @var \Drupal\digi_training\DigiTrainingInterface $entity */
    $row['id'] = $entity->id();
    $row['label'] = $entity->toLink();
    return $row + parent::buildRow($entity);
  }

}
