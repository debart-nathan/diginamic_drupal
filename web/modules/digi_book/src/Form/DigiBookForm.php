<?php

declare(strict_types = 1);

namespace Drupal\digi_book\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Form controller for the digi book entity edit forms.
 */
final class DigiBookForm extends ContentEntityForm {

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
        $this->messenger()->addStatus($this->t('New digi book %label has been created.', $message_args));
        $this->logger('digi_book')->notice('New digi book %label has been created.', $logger_args);
        if ($this->entity->bundle() === 'copy_book') {
          $this->addCopyToBook();
        }
        break;

      case SAVED_UPDATED:
        $this->messenger()->addStatus($this->t('The digi book %label has been updated.', $message_args));
        $this->logger('digi_book')->notice('The digi book %label has been updated.', $logger_args);
        break;

      default:
        throw new \LogicException('Could not save the entity.');
    }

    $route_url = Url::fromRoute('digi_book.management');
    $form_state->setRedirectUrl($route_url);

    return $result;
  }

  /**
   *
   */
  public function addCopyToBook() {
    // Récupération de l'id du book.
    $book_id = $this->entity->field_book[0]->target_id;

    // Chargement de l'entity book.
    $entity_book = \Drupal:: entityTypeManager()->getStorage("digi_book")->load($book_id);
    $entity_book->get('field_copy_book')->appendItem([
      'target_id' => $this->entity->id(),
    ]);

    $entity_book->save();
  }

}
