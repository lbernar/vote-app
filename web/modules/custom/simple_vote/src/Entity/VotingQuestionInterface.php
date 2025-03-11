<?php

namespace Drupal\simple_vote\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Question entities.
 *
 * @ingroup simple_vote
 */
interface VotingQuestionInterface extends ContentEntityInterface, EntityChangedInterface {

  /**
   * Get the question title.
   */
  public function getTitle(): string;

  /**
   * Set the question title.
   */
  public function setTitle($title): void;

  /**
   * Get the unique identifier.
   */
  public function getIdentifier(): string;

  /**
   * Set the unique identifier.
   */
  public function setIdentifier($identifier): void;
}