<?php

namespace Drupal\simple_vote\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\simple_vote\Service\VotingService;

class VotingResultsController extends ControllerBase {
  
  protected $votingService;

  public function __construct(VotingService $votingService) {
    $this->votingService = $votingService;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('simple_voting.voting_service')
    );
  }

  /**
   * Display voting results.
   */
  public function resultsPage($question_id) {
    $votes = $this->votingService->getVotesByAnswer($question_id);
    
    $rows = [];
    foreach ($votes as $answer_id => $data) {
      $answer = \Drupal\simple_voting\Entity\VotingAnswer::load($answer_id);
      $rows[] = [
        'data' => [
          $answer->getTitle(),
          $data['count'],
          $data['percentage'] . '%'
        ]
      ];
    }

    $header = [
      t('Answer'),
      t('Votes'),
      t('Percentage')
    ];

    return [
      '#theme' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#title' => t('Voting Results')
    ];
  }
}