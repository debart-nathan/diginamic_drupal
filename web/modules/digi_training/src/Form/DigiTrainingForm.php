<?php declare(strict_types = 1);

namespace Drupal\digi_training\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Form controller for the digi training entity edit forms.
 */
final class DigiTrainingForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state): int {
    $result = parent::save($form, $form_state);
  
    $message_args = ['%label' => $this->entity->toLink()->toString()];
    $logger_args = [
      '%label' => $this->entity->label(),
      'link' => $this->entity->toLink($this->t('View'))->toString(),
    ];
  
    switch ($result) {
      case SAVED_NEW:
        $this->messenger()->addStatus($this->t('New digi training %label has been created.', $message_args));
        $this->logger('digi_training')->notice('New digi training %label has been created.', $logger_args);
        if ($this->entity->bundle() === 'training_session') {
          $this->addSessionToTraining();
        }
        break;
  
      case SAVED_UPDATED:
        $this->messenger()->addStatus($this->t('The digi training %label has been updated.', $message_args));
        $this->logger('digi_training')->notice('The digi training %label has been updated.', $logger_args);
        break;
  
      default:
        throw new \LogicException('Could not save the entity.');
    }
  
    $route_url = Url::fromRoute('digi_training.management');
    $form_state->setRedirectUrl($route_url);
  
    return $result;
  }
  
  public function addSessionToTraining() {
    // Get the id of the training.
    $training_id = $this->entity->field_training[0]->target_id;
  
    // Load the training entity.
    $entity_training = \Drupal:: entityTypeManager()->getStorage("digi_training")->load($training_id);
    $entity_training->get('field_sessions')->appendItem([
      'target_id' => $this->entity->id(),
    ]);
  
    $entity_training->save();
  }
}