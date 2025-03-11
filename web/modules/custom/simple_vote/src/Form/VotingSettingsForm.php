<?php

namespace Drupal\simple_vote\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class VotingSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {
    return ['simple_vote.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'voting_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $config = $this->config('simple_vote.settings');

    $form['enable_voting'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable Voting System'),
      '#default_value' => $config->get('enable_voting'),
    ];

    $form['show_results'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Show results after voting'),
      '#default_value' => $config->get('show_results'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->config('simple_vote.settings')
      ->set('enable_voting', $form_state->getValue('enable_voting'))
      ->set('show_results', $form_state->getValue('show_results'))
      ->save();
    
    parent::submitForm($form, $form_state);
  }
}