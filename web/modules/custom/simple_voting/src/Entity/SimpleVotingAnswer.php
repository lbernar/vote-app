<?php

declare(strict_types=1);

namespace Drupal\simple_voting\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityChangedTrait;

/**
 * Defines the Simple Voting Answer entity.
 *
 * @ContentEntityType(
 *   id = "simple_voting_answer",
 *   label = @Translation("Simple Voting Answer"),
 *   base_table = "simple_voting_answer",
 *   handlers = {
 *     "storage" = "Drupal\Core\Entity\Sql\SqlContentEntityStorage",
 *     "list_builder" = "Drupal\simple_voting\SimpleVotingAnswerListBuilder",
 *     "form" = {
 *       "add" = "Drupal\simple_voting\Form\SimpleVotingAnswerForm",
 *       "edit" = "Drupal\simple_voting\Form\SimpleVotingAnswerForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *   },
 *   admin_permission = "administer simple_voting_answer",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *   },
 *   links = {
 *     "canonical" = "/admin/simple-voting-answer/{simple_voting_answer}",
 *     "edit-form" = "/admin/simple-voting-answer/{simple_voting_answer}/edit",
 *     "delete-form" = "/admin/simple-voting-answer/{simple_voting_answer}/delete",
 *     "collection" = "/admin/simple-voting-answer",
 *   }
 * )
 */
final class SimpleVotingAnswer extends ContentEntityBase implements SimpleVotingAnswerInterface {
  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type): array {
    $fields = parent::baseFieldDefinitions($entity_type);

    // Defining the 'question_id' field as an entity reference to 'simple_voting_question'.
    $fields['question_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Question'))
      ->setSetting('target_type', 'simple_voting_question')
      ->setRequired(TRUE);

    // Defining the 'label' field as a string (title of the answer).
    $fields['label'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Title'))
      ->setRequired(TRUE)
      ->setSetting('max_length', 255);

    // Defining the 'description' field as a long string for the answer description.
    $fields['description'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Description'))
      ->setDescription(t('A detailed description of the answer.'))
      ->setRequired(FALSE);

    // Defining the 'image' field to store the image of the answer.
    $fields['image'] = BaseFieldDefinition::create('image')
      ->setLabel(t('Image'))
      ->setDescription(t('The image of the answer.'))
      ->setRevisionable(TRUE)
      ->setDisplayOptions('view', [
        'type' => 'image',
        'weight' => 5,
        'label' => 'hidden',
        'settings' => [
          'image_style' => 'thumbnail',
        ],
      ])
      ->setReadOnly(TRUE);
    
    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getTitle(): string {
    return $this->get('label')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setTitle(string $title): void {
    $this->set('label', $title);
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription(): ?string {
    return $this->get('description')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setDescription(string $description): void {
    $this->set('description', $description);
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestionId(): int {
    return (int) $this->get('question_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setQuestion(SimpleVotingQuestionInterface $question): void {
    $this->set('question_id', $question->id());
  }

  /**
   * {@inheritdoc}
   */
  public function getImage(): ?array {
    $image_field = $this->get('image')->getValue();
    return !empty($image_field) ? array_column($image_field, 'target_id') : [];
  }

  /**
   * {@inheritdoc}
   */
  public function setImage(array $fid): void {
    $this->set('image', ['target_id' => $fid]);
  } 

  /**
   * {@inheritdoc}
   */
  public function getQuestion(): SimpleVotingQuestionInterface {
    return $this->get('question_id')->entity;
  }
}
