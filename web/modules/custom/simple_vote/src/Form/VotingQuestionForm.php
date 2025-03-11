<?php

namespace Drupal\simple_vote\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\simple_vote\Entity\VotingQuestion;

class VotingQuestionForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'voting_question_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Question Title'),
      '#required' => TRUE,
    ];

    $form['identifier'] = [
      '#type' => 'machine_name',
      '#title' => $this->t('Unique Identifier'),
      '#required' => TRUE,
      '#machine_name' => [
        'source' => ['title'],
        'exists' => '\Drupal\simple_vote\Form\VotingQuestionForm::identifierExists',
      ],
      '#prefix' => '<div id="edit-identifier">',
      '#suffix' => '</div>',
    ];

    $form['actions'] = [
      '#type' => 'actions',
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save Question'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->saveQuestion($form_state->getValues());
    \Drupal::messenger()->addMessage($this->t('Question saved!'));
  }

  /**
   * Saves the question entity.
   */
  private function saveQuestion(array $values): void {
    $question = VotingQuestion::create([
      'title' => $values['title'],
      'identifier' => $values['identifier'],
    ]);
    $question->save();
  }

  /**
   * Checks if the identifier already exists.
   */
  public static function identifierExists($identifier): bool {
    return (bool) \Drupal::entityQuery('voting_question')
      ->condition('identifier', $identifier)
      ->accessCheck(FALSE)
      ->count()
      ->execute();
  }
}
