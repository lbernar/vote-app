<?php

declare(strict_types=1);

namespace Drupal\simple_voting\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\simple_voting\Service\VotingResultsService;
use Drupal\simple_voting\Service\VotingResultsFormatterService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller to display voting results.
 */
class SimpleVotingResultsController extends ControllerBase {

  /**
   * Constructs a new SimpleVotingResultsController object.
   */
  public function __construct(
    protected VotingResultsService $votingResultsService,
    protected VotingResultsFormatterService $formatterService
  ) {}

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): self {
    return new self(
      $container->get('simple_voting.voting_results_service'),
      $container->get('simple_voting.voting_results_formatter')
    );
  }

  /**
   * Displays the voting results.
   */
  public function results(): array {
    $user_id = $this->currentUser()->id();
    $isAdmin = $this->currentUser()->hasPermission('administer simple_voting');

    // Check if results should be shown.
    $config = $this->config('simple_voting.settings');
    if (!$config->get('show_results_after_voting')) {
      return [
        '#markup' => $this->t('Results are hidden.'),
      ];
    }

    // Fetch results: Admins see all, users see only their own.
    $results = $isAdmin
      ? $this->votingResultsService->getVotingResults(NULL)
      : $this->votingResultsService->getVotingResults($user_id);

    return $this->formatterService->formatResults($results);
  }
}
