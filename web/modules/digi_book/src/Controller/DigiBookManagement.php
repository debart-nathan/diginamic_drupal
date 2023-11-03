<?php

namespace Drupal\digi_book\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\user\Entity\User;

class DigiBookManagement extends ControllerBase
{
  public function index()
  {
    // Récupération des données de l'utilisateur
    $current_user = \Drupal::currentUser();
    $query = \Drupal::entityQuery('digi_book');

    $digi_book_ids = $query
      ->accessCheck(TRUE)
      ->condition('bundle', 'book', "=")
      ->execute();
    $books = [];

    foreach ($digi_book_ids as $book_id) {
      // Chargement de toute l'entité book
      $book = \Drupal::entityTypeManager()->getStorage('digi_book')->load($book_id);

      //Ajout du titre pour chaque libre
      $books[$book_id] = [
        'title' => $book->get('label')->value,
      ];
      //Parcourt des exemplaires
      foreach ($book->get('field_copy_book') as $bc) {

        //Récupération des exemplaire par id
        $book_copy_id = $bc->target_id;
        $book_copy = \Drupal::entityTypeManager()->getStorage('digi_book')->load($book_copy_id);

        //recupération de l'entité user pour l'emprunteur
        $borrower_id = $book_copy->get('field_borrower')->target_id;

        $borrower = User::load($borrower_id);

        // Ajout du titre et de la date d'emprunt  des exemplaire
        $books[$book_id]["copies"][$book_copy_id] = [
          "title" => $book_copy->get('label')->value,
          'borrow_date'=> $book_copy->get('field_borrow_date')->value,
          'borrower' => [
              "name" => $borrower->name->value,
              "email" => $borrower->mail->value,
          ],
        ];
      }
    }

    return [
      '#theme' => 'books_management',
      '#user' => [
        "name" => $current_user->getAccountName(),
      ],
      '#books' => $books,
    ];
  }
}
