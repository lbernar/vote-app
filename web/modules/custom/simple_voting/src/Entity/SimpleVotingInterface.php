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
     * @return \Drupal\user\Entity\User|null
     *   The user entity associated with the vote, or NULL if not set.
     */
    public function getUser(): ?User;

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
     * @return int
     *   The timestamp of the vote as an integer.
     */
    public function getTimestamp(): ?int;

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
     * @return \Drupal\simple_voting\Entity\SimpleVotingQuestionInterface|null
     *   The question entity associated with the vote, or NULL if not set.
     */
    public function getQuestion(): ?SimpleVotingQuestionInterface;

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
     * @return \Drupal\simple_voting\Entity\SimpleVotingAnswerInterface|null
     *   The answer entity associated with the vote, or NULL if not set.
     */
    public function getAnswer(): ?SimpleVotingAnswerInterface;

    /**
     * Sets the answer entity associated with the vote.
     *
     * @param \Drupal\simple_voting\Entity\SimpleVotingAnswerInterface $answer
     *   The answer entity to associate with the vote.
     */
    public function setAnswer(SimpleVotingAnswerInterface $answer): void;

    /**
     * Gets the vote by user ID.
     *
     * @param int $userId
     *   The user ID.
     *
     * @return \Drupal\simple_voting\Entity\SimpleVotingInterface|null
     *   The vote entity if found, NULL otherwise.
     */
    public function getVoteByUserId(int $userId): ?SimpleVotingInterface;
}
