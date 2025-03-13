<?php

declare(strict_types=1);

namespace Drupal\simple_voting\Service;

use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Service to calculate and fetch voting results.
 */
final class VotingResultsService {

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new VotingResultsService object.
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * Fetches and processes voting results.
   *
   * @return array
   *   An associative array of voting results.
   */
  public function getVotingResults(): array {
    $storage = $this->entityTypeManager->getStorage('simple_voting');
    $votes = $storage->loadMultiple();

    $results = [];
    foreach ($votes as $vote) {
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
