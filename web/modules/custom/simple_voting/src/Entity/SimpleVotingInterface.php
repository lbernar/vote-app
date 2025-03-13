<?php

declare(strict_types=1);

namespace Drupal\simple_voting\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\Entity\User;

/**
 * Provides an interface defining a simple voting entity type.
 */
interface SimpleVotingInterface extends ContentEntityInterface {

    /**
     * Gets the user entity.
     *
     * @return \Drupal\user\Entity\User
     *   The user entity associated with the vote.
     */
    public function getUser(): User;

    /**
     * Sets the user entity.
     *
     * @param \Drupal\user\Entity\User $user
     *   The user entity to associate with the vote.
     */
    public function setUser(User $user): void;

    /**
     * Gets the timestamp of the vote.
     *
     * @return string
     *   The timestamp of the vote as a string.
     */
    public function getTimestamp(): string;

    /**
     * Sets the timestamp of the vote.
     *
     * @param int $timestamp
     *   The timestamp to set.
     */
    public function setTimestamp(int $timestamp): void;

    /**
     * Gets the question entity associated with the vote.
     *
     * @return \Drupal\simple_voting\Entity\SimpleVotingQuestionInterface
     *   The question entity associated with the vote.
     */
    public function getQuestion(): SimpleVotingQuestionInterface;

    /**
     * Sets the question entity associated with the vote.
     *
     * @param \Drupal\simple_voting\Entity\SimpleVotingQuestionInterface $question
     *   The question entity to associate with the vote.
     */
    public function setQuestion(SimpleVotingQuestionInterface $question): void;
  
    /**
     * Gets the answer entity associated with the vote.
     *
     * @return \Drupal\simple_voting\Entity\SimpleVotingAnswerInterface
     *   The answer entity associated with the vote.
     */
    public function getAnswer(): SimpleVotingAnswerInterface;

    /**
     * Sets the answer entity associated with the vote.
     *
     * @param \Drupal\simple_voting\Entity\SimpleVotingAnswerInterface $answer
     *   The answer entity to associate with the vote.
     */
    public function setAnswer(SimpleVotingAnswerInterface $answer): void;
}
