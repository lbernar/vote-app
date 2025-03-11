<?php

namespace Drupal\simple_vote\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Vote entities.
 *
 * @ingroup simple_vote
 */
interface VoteRecordInterface extends ContentEntityInterface, EntityOwnerInterface {

  /**
   * Gets the Question entity.
   *
   * @return \Drupal\simple_vote\Entity\VotingQuestionInterface
   *   The question entity.
   */
  public function getQuestion(): VotingQuestionInterface;

  /**
   * Gets the Question ID.
   *
   * @return int
   *   The question ID.
   */
  public function getQuestionId(): int;

  /**
   * Sets the Question ID.
   *
   * @param int $question_id
   *   The Question ID.
   */
  public function setQuestionId($question_id): void;

  /**
   * Gets the Answer entity.
   *
   * @return \Drupal\simple_vote\Entity\VotingAnswerInterface
   *   The answer entity.
   */
  public function getAnswer(): VotingAnswerInterface;

  /**
   * Gets the Answer ID.
   *
   * @return int
   *   The answer ID.
   */
  public function getAnswerId(): int;

  /**
   * Sets the Answer ID.
   *
   * @param int $answer_id
   *   The Answer ID.
   */
  public function setAnswerId($answer_id): void;
}