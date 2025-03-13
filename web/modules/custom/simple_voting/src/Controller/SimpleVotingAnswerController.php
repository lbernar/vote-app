<?php

declare(strict_types=1);

namespace Drupal\simple_voting\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a controller for displaying the answer form.
 */
class SimpleVotingAnswerController extends ControllerBase {

  /**
   * Constructs a new SimpleVotingAnswerController object.
   */
  public function __construct(
    protected FormBuilderInterface $formBuilder
  ) {}

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): self {
    return new self(
      $container->get('form_builder')
    );
  }

  /**
   * Displays the voting form.
   *
   * @return array
   *   A renderable array containing the form.
   */
  public function render(): array {
    return [
      '#title' => $this->t('Answer a Question'),
      'form' => $this->getVotingForm(),
    ];
  }

  /**
   * Fetches the voting form.
   *
   * @return array
   *   A renderable array for the form.
   */
  private function getVotingForm(): array {
    return $this->formBuilder->getForm('Drupal\simple_voting\Form\SimpleVotingAnswerForm');
  }
}
