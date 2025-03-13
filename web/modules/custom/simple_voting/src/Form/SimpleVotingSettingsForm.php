<?php

declare(strict_types=1);

namespace Drupal\simple_voting\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines the settings form for Simple Voting.
 */
final class SimpleVotingSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {
    return ['simple_voting.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'simple_voting_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $config = $this->config('simple_voting.settings');

    $form['enable_voting'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable voting system'),
      '#default_value' => $config->get('enable_voting') ?? TRUE,
      '#description' => $this->t('Uncheck this to disable voting for all users.'),
    ];

    $form['show_results_after_voting'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Show results after voting'),
      '#default_value' => $config->get('show_results_after_voting') ?? TRUE,
      '#description' => $this->t('If unchecked, users will not see the results after voting.'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->config('simple_voting.settings')
      ->set('enable_voting', $form_state->getValue('enable_voting'))
      ->set('show_results_after_voting', $form_state->getValue('show_results_after_voting'))
      ->save();
    parent::submitForm($form, $form_state);
  }
}
