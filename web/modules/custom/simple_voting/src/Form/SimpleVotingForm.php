<?php

declare(strict_types=1);

namespace Drupal\simple_voting\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\File\FileUrlGeneratorInterface;
use Drupal\Core\Render\RendererInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Voting form for users to select answers for questions.
 */
class SimpleVotingForm extends ContentEntityForm {

  /**
   * Class constructor.
   */
  public function __construct(
    protected EntityStorageInterface $questionStorage, 
    protected EntityStorageInterface $answerStorage,
    protected EntityStorageInterface $votingStorage,
    protected RendererInterface $renderer,
    protected FileUrlGeneratorInterface $fileUrlGenerator,
  ) {}

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): self {
    return new static(
      $container->get('entity_type.manager')->getStorage('simple_voting_question'),
      $container->get('entity_type.manager')->getStorage('simple_voting_answer'),
      $container->get('entity_type.manager')->getStorage('simple_voting'),
      $container->get('renderer'),
      $container->get('file_url_generator'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'simple_voting_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $config = \Drupal::config('simple_voting.settings');

    // Check if voting is disabled.
    if (!$config->get('enable_voting')) {
      return [
        '#markup' => $this->t('Voting is currently disabled. Please try again later.'),
      ];
    }

    $questions = $this->questionStorage->loadMultiple();

    if (empty($questions)) {
      $form['message'] = [
        '#markup' => $this->t('No questions available for voting.'),
      ];
      return $form;
    }

    // Iterate over each question and build its form elements.
    foreach ($questions as $question) {
      $answers = $this->answerStorage->loadByProperties(['question_id' => $question->id()]);
      $options = $this->generateAnswerOptions($answers);

      if (!empty($options)) {
        $form['question_' . $question->id()] = [
          '#type' => 'radios',
          '#title' => $question->label(),
          '#options' => $options,
          '#required' => TRUE,
        ];
      }
    }

    // Add submit button.
    $form['actions'] = [
      '#type' => 'actions',
      'submit' => [
        '#type' => 'submit',
        '#value' => $this->t('Vote'),
      ],
    ];

    return $form;
  }

  /**
   * Generate the options for answers including images and labels.
   *
   * @param \Drupal\simple_voting\Entity\SimpleVotingAnswer[] $answers
   *   The list of answer entities.
   *
   * @return array
   *   The options for the radio buttons with image HTML and label.
   */
  protected function generateAnswerOptions(array $answers): array {
    $options = [];
    foreach ($answers as $answer) {
      $answer_id = $answer->id();
      $label = $answer->label();
      
      // Generate HTML for image and label together.
      $image_html = $this->generateImageHtml($answer->get('image')->target_id, $label);
      $options[$answer_id] = $image_html . $label;
    }
    return $options;
  }

  /**
   * Generate HTML for the image.
   *
   * @param int|null $image_fid
   *   The file ID of the image.
   * @param string $alt_text
   *   The alt text for the image.
   *
   * @return string
   *   The HTML string for the image.
   */
  protected function generateImageHtml(?string $image_fid, string $alt_text): string {
    if (!$image_fid) {
      return ''; // Return an empty string if no image.
    }

    $file = \Drupal\file\Entity\File::load($image_fid);
    if ($file) {
      $image_url = $this->fileUrlGenerator->generateAbsoluteString($file->getFileUri());
      return '<img src="' . $image_url . '" alt="' . $alt_text . '"width=100px; height=100px; margin-right: 10px; vertical-align: middle;" />';
    }

    return ''; // Return empty string if no file found.
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $values = $form_state->getValues();

    // Save votes for the selected answers.
    foreach ($values as $key => $value) {
      if (strpos($key, 'question_') === 0 && !empty($value)) {
        $question_id = str_replace('question_', '', $key);
        $answer_id = $value;
        $this->votingStorage->create([
          'question_id' => $question_id,
          'answer_id' => $answer_id,
          'user_id' => \Drupal::currentUser()->id(),
          'timestamp' => \Drupal::time()->getRequestTime(),
        ])->save();
      }
    }

    // Provide feedback to the user.
    $this->messenger()->addMessage($this->t('Your vote has been submitted!'));
  }
}