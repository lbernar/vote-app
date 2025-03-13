<?php

declare(strict_types=1);

namespace Drupal\simple_voting\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Provides a controller for displaying the voting form.
 */
final class SimpleVotingController extends ControllerBase {

  /**
   * Displays the voting form.
   *
   * @return array
   *   A renderable array containing the form.
   */
  public function vote(): array {
    return [
      '#title' => $this->t('Vote for a Question'),
      'form' => $this->formBuilder()->getForm('Drupal\simple_voting\Form\SimpleVotingForm'),
    ];
  }
}
