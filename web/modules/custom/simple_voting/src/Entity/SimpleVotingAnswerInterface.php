<?php

declare(strict_types=1);

namespace Drupal\simple_voting\Entity;

use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Provides an interface defining a simple voting answer entity type.
 */
interface SimpleVotingAnswerInterface extends ContentEntityInterface {

    /**
     * Gets the title of the answer.
     *
     * @return string
     *   The title of the answer.
     */
    public function getTitle(): string;

    /**
     * Sets the title of the answer.
     *
     * @param string $title
     *   The title of the answer.
     */
    public function setTitle(string $title): void;

    /**
     * Gets the description of the answer.
     *
     * @return string|null
     *   The description of the answer, or null if none.
     */
    public function getDescription(): ?string;

    /**
     * Sets the description of the answer.
     *
     * @param string $description
     *   The description of the answer.
     */
    public function setDescription(string $description): void;

    /**
     * Gets the question entity associated with the answer.
     *
     * @return \Drupal\simple_voting\Entity\SimpleVotingQuestionInterface
     *   The question entity associated with the answer.
     */
    public function getQuestion(): SimpleVotingQuestionInterface;

    /**
     * Gets the ID of the associated question.
     *
     * @return int
     *   The ID of the associated question.
     */
    public function getQuestionId(): int;

    /**
     * Sets the question entity associated with the answer.
     *
     * @param \Drupal\simple_voting\Entity\SimpleVotingQuestionInterface $question
     *   The question entity to associate with the answer.
     */
    public function setQuestion(SimpleVotingQuestionInterface $question): void;

    /**
     * Gets the image associated with the answer.
     *
     * @return array|null
     *   The image associated with the answer, or null if no image is set.
     */
    public function getImage(): ?array;

    /**
     * Sets the image associated with the answer.
     *
     * @param array $fid
     *   The file ID(s) of the image(s) to associate with the answer.
     */
    public function setImage(array $fid): void;
}
