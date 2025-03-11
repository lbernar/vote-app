<?php

namespace Drupal\simple_vote\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\simple_vote\Entity\VotingAnswerInterface;

class VotingAnswerForm extends FormBase {

  public function getFormId() {
    return 'voting_answer_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['question_id'] = [
      '#type' => 'entity_autocomplete',
      '#title' => $this->t('Select Question'),
      '#target_type' => 'voting_question',
      '#required' => TRUE,
    ];

    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Answer Title'),
      '#required' => TRUE,
    ];

    $form['description'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Description'),
    ];

    $form['image'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Upload Image'),
      '#upload_location' => 'public://voting_answers/',
      '#required' => FALSE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save Answer'),
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $answer = VotingAnswerInterface::create([
      'question_id' => $values['question_id'],
      'title' => $values['title'],
      'description' => $values['description'],
      'image' => $values['image'],
    ]);
    $answer->save();
    \Drupal::messenger()->addMessage($this->t('Answer saved!'));
  }
}