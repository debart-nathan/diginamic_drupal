<?php

namespace Drupal\digi_training\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\user\Entity\User;

final class DigiTrainingManagement extends ControllerBase
{
  public function index()
  {
    $current_user = \Drupal::currentUser();
    $query = \Drupal::entityQuery('digi_training');

    $digi_training_ids = $query
      ->accessCheck(TRUE)
      ->condition('bundle', 'training', "=")
      ->execute();
    $trainings = [];

    foreach ($digi_training_ids as $training_id) {
      $training = \Drupal::entityTypeManager()->getStorage('digi_training')->load($training_id);

      $trainings[$training_id] = [
        'title' => $training->get('label')->value,
        'description' => $training->get('field_description')->value,
      ];

      foreach ($training->get('field_sessions') as $st) {
        $session_id = $st->target_id;
        $session = \Drupal::entityTypeManager()->getStorage('digi_training')->load($session_id);

        if ($session === NULL) {
          \Drupal::logger('digi_training')->error('Training session with ID @id not found', ['@id' => $session_id]);
          continue;
        }

        $trainers = [];
        foreach ($session->get('field_trainers') as $trainer) {
          $trainer_id = $trainer->target_id;
          $trainer_user = User::load($trainer_id);
          $trainers[] = [
            "name" => $trainer_user->name->value,
            "email" => $trainer_user->mail->value,
          ];
        }

        $trainings[$training_id]["sessions"][$session_id] = [
          "title" => $session->get('label')->value,
          'start_date' => $session->get('field_starting_date')->value,
          'end_date' => $session->get('field_ending_date')->value,
          'trainers' => $trainers,
        ];
      }
    }

    return [
      '#theme' => 'trainings_management',
      '#user' => [
        "name" => $current_user->getAccountName(),
      ],
      '#trainings' => $trainings,
      '#cache' => ['max-age' => 0], // Disable cache for this page
    ];
  }
}
