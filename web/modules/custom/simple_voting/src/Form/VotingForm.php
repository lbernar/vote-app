<?php

namespace Drupal\simple_voting\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class VotingForm.
 *
 * Provides a form for users to submit their votes.
 */
class VotingForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'voting_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Example question and options.
    $form['question'] = [
      '#type' => 'markup',
      '#markup' => $this->t('What is your favorite color?'),
    ];

    $form['options'] = [
      '#type' => 'radios',
      '#title' => $this->t('Choose an option'),
      '#options' => [
        'red' => $this->t('Red'),
        'blue' => $this->t('Blue'),
        'green' => $this->t('Green'),
      ],
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Vote'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Handle the form submission logic here.
    $selected_option = $form_state->getValue('options');
    // Save the vote to the database or process it as needed.
    drupal_set_message($this->t('You voted for: @option', ['@option' => $selected_option]));
  }

}