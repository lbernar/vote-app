<?php

declare(strict_types=1);

namespace Drupal\simple_voting\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\simple_voting\Entity\SimpleVotingAnswer;
use Drupal\simple_voting\Entity\SimpleVotingQuestion;

/**
 * Form for creating and editing Simple Voting Answer entities.
 */
final class SimpleVotingAnswerForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state): array {

    $form = parent::form($form, $form_state);

    // Title field for the answer.
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#maxlength' => 255,
      '#default_value' => $this->entity->label(),
      '#required' => TRUE,
    ];

    // Machine name field for the answer.
    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $this->entity->id(),
      '#machine_name' => [
        'exists' => [SimpleVotingAnswer::class, 'load'],
      ],
      '#disabled' => !$this->entity->isNew(),
    ];

    // Description field for the answer.
    $form['description'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Description'),
      '#default_value' => $this->entity->getDescription(),
    ];

    // Dropdown for selecting the associated question.
    $questions = SimpleVotingQuestion::loadMultiple();
    $options = [];
    foreach ($questions as $question) {
      $options[$question->id()] = $question->label();
    }

    $form['question_id'] = [
      '#type' => 'select',
      '#title' => $this->t('Associated Question'),
      '#options' => $options,
      '#default_value' => $this->entity->getQuestionId() ?? '',
      '#required' => TRUE,
    ];

    // Image upload field.
    $form['image'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Image'),
      '#upload_location' => 'public://simple_voting_answers/',
      '#default_value' => $this->entity->getImage(),
      '#required' => FALSE,
      '#description' => $this->t('Upload an image for this answer.'),
      '#upload_validators' => [
        'file_validate_extensions' => ['png jpg jpeg gif'],
        'file_validate_size' => [25600000], // Max 25MB
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state): int {
    // Handle the image file upload.
    $fid = $form_state->getValue('image');
    if (!empty($fid) && is_array($fid)) {
      $this->entity->set('image', reset($fid)); // Set the image file ID.
    }

    // Save the entity and display an appropriate status message.
    $result = parent::save($form, $form_state);
    $message_args = ['%label' => $this->entity->label()];
    $this->messenger()->addStatus(
      match($result) {
        \SAVED_NEW => $this->t('Created new answer.', $message_args),
        \SAVED_UPDATED => $this->t('Updated the answer.', $message_args),
      }
    );

    // Redirect to the collection page after saving.
    $form_state->setRedirectUrl($this->entity->toUrl('collection'));
    return $result;
  }
}
