<?php

declare(strict_types=1);

namespace Drupal\simple_voting\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\simple_voting\Service\VotingResultsService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller to display voting results.
 */
final class SimpleVotingResultsController extends ControllerBase {

  /**
   * @var \Drupal\simple_voting\Service\VotingResultsService
   */
  protected $votingResultsService;

  /**
   * Constructs a new SimpleVotingResultsController object.
   */
  public function __construct(VotingResultsService $votingResultsService) {
    $this->votingResultsService = $votingResultsService;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): self {
    return new self(
      $container->get('simple_voting.voting_results_service')
    );
  }

  /**
   * Displays the voting results.
   */
  public function results(): array {
    // Check if results should be shown.
    $config = $this->config('simple_voting.settings');
    if (!$config->get('show_results_after_voting')) {
      return [
        '#markup' => $this->t('Results are hidden.'),
      ];
    }

    $results = $this->votingResultsService->getVotingResults();

    if (empty($results)) {
      return [
        '#markup' => $this->t('No votes recorded yet.'),
      ];
    }

    // Render results
    $build = [
      '#theme' => 'item_list',
      '#items' => [],
    ];

    foreach ($results as $question) {
      $items = [];
      foreach ($question['answers'] as $answer) {
        $items[] = $this->t('Answer: @label, Votes: @count, Percentage @percentage%', [
          '@label' => $answer['label'],
          '@count' => $answer['count'],
          '@percentage' => round(($answer['count'] / array_sum(array_column($question['answers'], 'count'))) * 100),
        ]);
      }

      $build['#items'][] = [
        '#markup' => '<h3>' . $question['question'] . '</h3>',
        'list' => [
          '#theme' => 'item_list',
          '#items' => $items,
        ],
      ];
    }

    return $build;
  }
}
