<?php

namespace Drupal\simple_voting\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a 'VotingBlock' block.
 *
 * @Block(
 *   id = "voting_block",
 *   admin_label = @Translation("Voting Block"),
 *   category = @Translation("Custom"),
 * )
 */
class VotingBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    // Render the voting form.
    $form = \Drupal::formBuilder()->getForm('Drupal\simple_voting\Form\VotingForm');
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockAccess(AccountInterface $account) {
    // Define access control for the block.
    return $account->hasPermission('access voting block');
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    // Provide settings for the block.
    $settings = parent::settingsForm($form, $form_state);
    // Add custom settings here if needed.
    return $settings;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    // Provide a summary of the block settings.
    $summary = parent::settingsSummary();
    // Add custom summary items here if needed.
    return $summary;
  }

}