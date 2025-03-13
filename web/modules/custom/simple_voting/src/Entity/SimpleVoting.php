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
 *   links = {
 *     "collection" = "/admin/structure/simple-voting",
 *     "add-form" = "/admin/structure/simple-voting/add",
 *   },
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "question_id",
 *     "uuid" = "uuid",
 *   },
 * )
 */
final class SimpleVoting extends ContentEntityBase implements SimpleVotingInterface {

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

    // Defining the 'answer_id' field as an entity reference to 'simple_voting_answer'.
    $fields['answer_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Selected Answer'))
      ->setSetting('target_type', 'simple_voting_answer')
      ->setRequired(TRUE);

    // Defining the 'user_id' field as an entity reference to 'user'.
    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Voter'))
      ->setSetting('target_type', 'user')
      ->setRequired(TRUE);

    // Defining the 'timestamp' field, using 'created' as the field type.
    $fields['timestamp'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Timestamp'))
      ->setRequired(TRUE);

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getUser(): User {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function setUser(User $user): void {
    $this->set('user_id', $user);
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion(): SimpleVotingQuestionInterface {
    return $this->get('question_id')->entity;
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
  public function getAnswer(): SimpleVotingAnswerInterface {
    return $this->get('answer_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function setAnswer(SimpleVotingAnswerInterface $answer): void {
    $this->set('answer_id', $answer->id());
  }

  /**
   * {@inheritdoc}
   */
  public function getTimestamp(): string {
    return $this->get('timestamp')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setTimestamp(int $timestamp): void {
    $this->set('timestamp', $timestamp);
  }
}
