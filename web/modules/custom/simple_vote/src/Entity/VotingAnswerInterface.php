<?php

namespace Drupal\simple_vote\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Provides an interface for defining Answer entities.
 *
 * @ingroup simple_vote
 */
interface VotingAnswerInterface extends ContentEntityInterface, EntityChangedInterface {

  /**
   * Gets the Answer title.
   *
   * @return string
   *   Title of the Answer.
   */
  public function getTitle(): string;

  /**
   * Sets the Answer title.
   *
   * @param string $title
   *   The Answer title.
   */
  public function setTitle($title): void;

  /**
   * Gets the Answer description.
   *
   * @return string
   *   Description of the Answer.
   */
  public function getDescription(): string;

  /**
   * Sets the Answer description.
   *
   * @param string $description
   *   The Answer description.
   */
  public function setDescription($description): void;

  /**
   * Gets the Question entity.
   *
   * @return \Drupal\simple_vote\Entity\QuestionInterface
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

}