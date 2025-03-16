<?php

declare(strict_types=1);

namespace Drupal\simple_voting\Service;

use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Service to calculate and fetch voting results.
 */
class VotingResultsService {

  /**
   * Constructs a new VotingResultsService object.
   */
  public function __construct(
    protected EntityTypeManagerInterface $entityTypeManager,
  ) {}

  /**
   * Fetches and processes voting results.
   *
   * @param int|null $userId
   *   The user ID to fetch results for.
   * @return array
   *   An associative array of voting results.
   */
  public function getVotingResults(?int $userId): array {
    /** @var \Drupal\simple_voting\Entity\SimpleVotingStorage $storage */
    $storage = $this->entityTypeManager->getStorage('simple_voting');
    if ($userId) {
      $votes = $storage->loadByProperties(['user_id' => $userId]);
    }
    else {
      $votes = $storage->loadMultiple();
    }
    $results = [];
    foreach ($votes as $vote) {
      /** @var \Drupal\simple_voting\Entity\SimpleVotingInterface $vote */
      $question = $vote->getQuestion();
      $answer = $vote->getAnswer();
      if ($question && $answer) {
        $question_id = $question->id();
        $answer_id = $answer->id();

        $results[$question_id]['question'] = $question->label();
        if (!isset($results[$question_id]['answers'][$answer_id])) {
          $results[$question_id]['answers'][$answer_id] = [
            'label' => $answer->label(),
            'count' => 0,
          ];
        }
        $results[$question_id]['answers'][$answer_id]['count']++;
      }
    }

    return $results;
  }
}
