<?php
namespace Drupal\digi_book\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\user\Entity\User;

class DigiBookManagement extends ControllerBase {
  public function index() {
    // Récupération des données de l'utilisateur
    $current_user = \Drupal::currentUser();
    //dpm( $current_user);
    $drupal_account = User::load($current_user->id());
    return [
      '#theme' => 'books_management',
      '#user' => [
        "name" => $current_user->getAccountName(),
      ],
    ];
  }
}