<?php

namespace Drupal\simple_vote\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\simple_vote\Entity\VoteRecordInterface;
use Drupal\simple_vote\Entity\VotingAnswerInterface;
use Drupal\simple_vote\Entity\VotingQuestionInterface;

/**
 * Defines the Voting Record entity.
 *
 * @ContentEntityType(
 *   id = "vote_record",
 *   label = @Translation("Voting Record"),
 *   base_table = "vote_record",
 *   entity_keys = {
 *     "id" = "id",
 *   },
 * )
 */
class VoteRecord extends ContentEntityBase implements VoteRecordInterface {
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

    $fields['answer_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Selected Answer'))
      ->setSetting('target_type', 'voting_answer')
      ->setRequired(TRUE);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Voter'))
      ->setSetting('target_type', 'user')
      ->setRequired(TRUE);

    $fields['timestamp'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Timestamp'));

    return $fields;
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
  public function getAnswerId(): int {
    return $this->get('answer_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setAnswerId($answer_id): void {
    $this->set('answer_id', $answer_id);
  }

  /**
   * {@inheritdoc}
   */
  public function getUserId(): int {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setUserId($user_id): void {
    $this->set('user_id', $user_id);
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion(): VotingQuestionInterface {
    return $this->get('question_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getAnswer(): VotingAnswerInterface {
    return $this->get('answer_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner(): VotingAnswerInterface {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner($owner): void {
    $this->set('user_id', $owner->id());
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId(): int {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($owner_id): void {
    $this->set('user_id', $owner_id);
  }

  /**
   * {@inheritdoc}
   */
  public function getTimestamp(): int {
    return $this->get('timestamp')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setTimestamp($timestamp): void {
    $this->set('timestamp', $timestamp);
  }
}
