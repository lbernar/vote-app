<?php

declare(strict_types=1);

namespace Drupal\simple_voting\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\user\Entity\User;

/**
 * Defines the simple voting entity type.
 *
 * @ContentEntityType(
 *   id = "simple_voting",
 *   label = @Translation("Simple Voting"),
 *   base_table = "simple_voting",
 *   handlers = {
 *     "storage" = "Drupal\Core\Entity\Sql\SqlContentEntityStorage",
 *     "list_builder" = "Drupal\simple_voting\SimpleVotingListBuilder",
 *     "form" = {
 *       "add" = "Drupal\simple_voting\Form\SimpleVotingForm",
 *     },
 *   },
 *   admin_permission = "administer simple_voting",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "question_id",
 *     "uuid" = "uuid",
 *   },
 * )
 */
class SimpleVoting extends ContentEntityBase implements SimpleVotingInterface {

  private const ENTITY_TYPE_ID = 'simple_voting';
  private const QUESTION_ID = 'question_id';
  private const ANSWER_ID = 'answer_id';
  private const USER_ID = 'user_id';
  private const TIMESTAMP = 'timestamp';
  private const SIMPLE_VOTING_QUESTION = 'simple_voting_question';
  private const SIMPLE_VOTING_ANSWER = 'simple_voting_answer';
  

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type): array {
    $fields = parent::baseFieldDefinitions($entity_type);

    // Defining the 'question_id' field as an entity reference to 'simple_voting_question'.
    $fields[self::QUESTION_ID] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Question'))
      ->setSetting('target_type', self::SIMPLE_VOTING_QUESTION)
      ->setRequired(TRUE);

    // Defining the 'answer_id' field as an entity reference to 'simple_voting_answer'.
    $fields[self::ANSWER_ID] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Selected Answer'))
      ->setSetting('target_type', self::SIMPLE_VOTING_ANSWER)
      ->setRequired(TRUE);

    // Defining the 'user_id' field as an entity reference to 'user'.
    $fields[self::USER_ID] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Voter'))
      ->setSetting('target_type', 'user')
      ->setRequired(TRUE);

    // Defining the 'timestamp' field, using 'created' as the field type.
    $fields[self::TIMESTAMP] = BaseFieldDefinition::create('created')
      ->setLabel(t('Timestamp'))
      ->setRequired(TRUE);

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getUser(): ?User {
    return $this->get(self::USER_ID)->entity ?: NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function setUser(User $user): void {
    $this->set(self::USER_ID, $user);
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion(): ?SimpleVotingQuestionInterface {
    return $this->get(self::QUESTION_ID)->entity ?: NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function setQuestion(SimpleVotingQuestionInterface $question): void {
    $this->set(self::QUESTION_ID, $question->id());
  }

  /**
   * {@inheritdoc}
   */
  public function getAnswer(): ?SimpleVotingAnswerInterface {
    return $this->get(self::ANSWER_ID)->entity ?: NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function setAnswer(SimpleVotingAnswerInterface $answer): void {
    $this->set(self::ANSWER_ID, $answer->id());
  }

  /**
   * {@inheritdoc}
   */
  public function getTimestamp(): ?int {
    return (int)$this->get(self::TIMESTAMP)->value ?: NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function setTimestamp(int $timestamp): void {
    $this->set(self::TIMESTAMP, $timestamp);
  }

  /**
   * {@inheritdoc}
   */
  public function getVoteByUserId(int $userId): ?SimpleVotingInterface {
    $vote_storage = $this->entityTypeManager()->getStorage(self::ENTITY_TYPE_ID);
    $votes = $vote_storage->loadByProperties([self::USER_ID => $userId]);

    return reset($votes) ?: NULL;
  }
}
