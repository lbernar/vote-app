<?php

declare(strict_types=1);

namespace Drupal\simple_voting\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Drupal\user\Entity\User;

/**
 * Handles API requests for voting.
 */
class SimpleVotingApiController extends ControllerBase {

  /**
   * Registers a vote.
   */
  public function registerVote(Request $request): JsonResponse {
    $data = json_decode($request->getContent(), true);
    if (!isset($data['question_id'], $data['answer_id'])) {
      return new JsonResponse(['error' => 'Invalid request data'], 400);
    }

    $voteStorage = $this->entityTypeManager()->getStorage('simple_voting');
    $userId = $this->currentUser()->id();

    $vote = $voteStorage->create([
      'question_id' => $data['question_id'],
      'answer_id' => $data['answer_id'],
      'user_id' => $userId,
      'timestamp' => time(),
    ]);
    $vote->save();

    return new JsonResponse(['message' => 'Vote registered successfully'], 201);
  }

  /**
   * Retrieves voting results.
   */
  public function getResults(): JsonResponse {
    $votes = $this->entityTypeManager()->getStorage('simple_voting')->loadMultiple();
    $results = [];

    foreach ($votes as $vote) {
      $questionId = $vote->get('question_id')->target_id;
      $answerId = $vote->get('answer_id')->target_id;
      
      if (!isset($results[$questionId])) {
        $results[$questionId] = [];
      }
      
      if (!isset($results[$questionId][$answerId])) {
        $results[$questionId][$answerId] = 0;
      }
      
      $results[$questionId][$answerId]++;
    }

    return new JsonResponse(['results' => $results], 200);
  }
}
