<?php

namespace Drupal\simple_vote\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\simple_vote\Entity\VoteInterface;
use Drupal\simple_vote\Entity\VotingAnswerInterface;
use Drupal\simple_vote\Entity\VotingQuestionInterface;

class VoteForm extends FormBase {

  public function getFormId() {
    return 'vote_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $questions = VotingQuestionInterface::loadMultiple();
    $options = [];

    foreach ($questions as $question) {
      $answers = \Drupal::entityQuery('voting_answer')
        ->condition('question_id', $question->id())
        ->execute();

      if (!empty($answers)) {
        $form['question_' . $question->id()] = [
          '#type' => 'radios',
          '#title' => $this->t($question->get('title')->value),
          '#options' => $this->getAnswerOptions($answers),
          '#required' => TRUE,
        ];
      }
    }

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Vote'),
    ];

    return $form;
  }

  private function getAnswerOptions($answer_ids) {
    $options = [];
    $answers = VotingAnswerInterface::loadMultiple($answer_ids);
    foreach ($answers as $answer) {
      $options[$answer->id()] = $answer->get('title')->value;
    }
    return $options;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    foreach ($form_state->getValues() as $key => $value) {
      if (strpos($key, 'question_') === 0 && !empty($value)) {
        $vote = VoteInterface::create([
          'question_id' => str_replace('question_', '', $key),
          'answer_id' => $value,
          'user_id' => \Drupal::currentUser()->id(),
        ]);
        $vote->save();
      }
    }
    \Drupal::messenger()->addMessage($this->t('Your vote has been recorded!'));
  }
}