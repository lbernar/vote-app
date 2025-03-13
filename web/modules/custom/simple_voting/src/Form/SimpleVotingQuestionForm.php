<?php

declare(strict_types=1);

namespace Drupal\simple_voting\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\simple_voting\Entity\SimpleVotingQuestion;

/**
 * Simple Voting Question form.
 */
final class SimpleVotingQuestionForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state): array {

    $form = parent::form($form, $form_state);

    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#maxlength' => 255,
      '#default_value' => $this->entity->label(),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $this->entity->id(),
      '#machine_name' => [
        'exists' => [SimpleVotingQuestion::class, 'load'],
      ],
      '#disabled' => !$this->entity->isNew(),
    ];

    $form['allow_results_view'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Allow Results View'),
      '#default_value' => $this->entity->isResultsViewAllowed(),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state): int {
    $result = parent::save($form, $form_state);
    $this->messenger()->addStatus(
      match($result) {
        \SAVED_NEW => $this->t('Created new question.'),
        \SAVED_UPDATED => $this->t('Updated question.'),
      }
    );
    $form_state->setRedirectUrl($this->entity->toUrl('collection'));
    return $result;
  }

}
