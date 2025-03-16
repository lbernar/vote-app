<?php

declare(strict_types=1);

namespace Drupal\simple_voting\Service;

use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Service to format voting results for display.
 */
class VotingResultsFormatterService {

  use StringTranslationTrait;

  /**
   * Formats the voting results for display.
   */
  public function formatResults(array $results): array {
    if (empty($results)) {
      return [
        '#markup' => $this->t('No votes recorded yet.'),
      ];
    }

    $build = [
      '#theme' => 'item_list',
      '#items' => [],
    ];

    foreach ($results as $question) {
      $totalVotes = array_sum(array_column($question['answers'], 'count'));

      $items = [];
      foreach ($question['answers'] as $answer) {
        $percentage = $totalVotes > 0 ? round(($answer['count'] / $totalVotes) * 100, 2) : 0;
        $items[] = $this->t('Answer: @label - Votes: @count (@percentage%)', [
          '@label' => $answer['label'],
          '@count' => $answer['count'],
          '@percentage' => $percentage,
        ]);
      }

      $build['#items'][] = [
        '#markup' => '<h3>' . $question['question'] . '</h3>',
        'total_votes' => [
          '#markup' => '<p><strong>Total Votes:</strong> ' . $totalVotes . '</p>',
        ],
        'answers' => [
          '#theme' => 'item_list',
          '#items' => $items,
        ],
      ];
    }

    return $build;
  }
}
