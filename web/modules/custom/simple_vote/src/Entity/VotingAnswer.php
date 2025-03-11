<?php

namespace Drupal\simple_vote\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the Voting Answer entity.
 *
 * @ContentEntityType(
 *   id = "voting_answer",
 *   label = @Translation("Voting Answer"),
 *   base_table = "voting_answer",
 *   entity_keys = {
 *    "id" = "id",
 *    "title" = "title",
 *    "description" = "description",
 *    "question_id" = "question_id",
 *    "image" = "image",
 *   },
 * )
 */
class VotingAnswer extends ContentEntityBase implements VotingAnswerInterface {
  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['question_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Question'))
      ->setSetting('target_type', 'voting_question')
      ->setRequired(TRUE);

    $fields['title'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Title'))
      ->setRequired(TRUE);

    $fields['description'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Description'));

    $fields['image'] = BaseFieldDefinition::create('uri')
      ->setLabel(t('Image'));

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getTitle(): string {
    return $this->get('title')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setTitle($title): void {
    $this->set('title', $title);
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription(): string {
    return $this->get('description')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setDescription($description): void {
    $this->set('description', $description);
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestionId(): int {
    return $this->get('question_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setQuestionId($question_id): void {
    $this->set('question_id', $question_id);
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion(): VotingQuestionInterface
  {
    return $this->get('question_id')->value;
  }
}
