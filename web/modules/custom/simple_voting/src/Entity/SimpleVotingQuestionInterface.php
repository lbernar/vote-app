<?php

declare(strict_types=1);

namespace Drupal\simple_voting\Entity;

use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Provides an interface for defining Simple Voting Question entities.
 */
interface SimpleVotingQuestionInterface extends ContentEntityInterface {

  /**
   * Checks if the results should be visible after voting.
   *
   * @return bool
   *   TRUE if results should be visible after voting, FALSE otherwise.
   */
  public function isResultsViewAllowed(): bool;

  /**
   * Sets whether the results should be visible after voting.
   *
   * @param bool $allowed
   *   TRUE to allow results to be viewed after voting, FALSE otherwise.
   */
  public function setResultsViewAllowed(bool $allowed): void;

  /**
   * Gets the question title.
   *
   * @return string
   *   The title of the question.
   */
  public function getTitle(): string;

  /**
   * Sets the question title.
   *
   * @param string $title
   *   The title of the question.
   */
  public function setTitle(string $title): void;
}
