<?php

declare(strict_types=1);

namespace Drupal\simple_voting\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\simple_voting\Traits\ImageHtmlGeneratorTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Exception;

/**
 * Controller for the Simple Voting API.
 */
class SimpleVotingApiController extends ControllerBase {
  use ImageHtmlGeneratorTrait;

  /**
   * Lists available questions for voting.
   */
  public function getQuestions(): JsonResponse {
    try {
      $questions = $this->entityTypeManager()->getStorage('simple_voting_question')->loadMultiple();
      $data = [];

      foreach ($questions as $question) {
        $answers = $this->entityTypeManager()->getStorage('simple_voting_answer')->loadByProperties(['question_id' => $question->id()]);
        $answer_data = [];

        foreach ($answers as $answer) {
          /** @var \Drupal\simple_voting\Entity\SimpleVotingAnswerInterface $answer */
          $answer_data[] = [
            'id' => $answer->id(),
            'label' => $answer->getTitle(),
            'image' => $this->getImageUrl((int)reset($answer->getImage())),
          ];
        }

        $data[] = [
          'id' => $question->id(),
          'title' => $question->label(),
          'answers' => $answer_data,
        ];
      }

      return new JsonResponse($data);
    } catch (Exception $e) {
      return new JsonResponse(['error' => 'An error occurred while fetching questions.', 'details' => $e->getMessage()], 500);
    }
  }

  /**
   * Registers a vote.
   */
  public function vote(Request $request): JsonResponse {
    try {
      $data = json_decode($request->getContent(), TRUE);

      if (empty($data['question_id']) || empty($data['answer_id'])) {
        return new JsonResponse(['error' => 'Invalid data.'], 400);
      }

      $vote = $this->entityTypeManager()->getStorage('simple_voting')->create([
        'question_id' => $data['question_id'],
        'answer_id' => $data['answer_id'],
        'user_id' => $this->currentUser()->id(),
        'timestamp' => \Drupal::time()->getRequestTime(),
      ]);
      $vote->save();

      return new JsonResponse(['message' => 'Vote registered successfully!']);
    } catch (Exception $e) {
      return new JsonResponse(['error' => 'An error occurred while registering the vote.', 'details' => $e->getMessage()], 500);
    }
  }

  /**
   * Retrieves voting results.
   */
  public function getResults(): JsonResponse {
    try {
      $is_admin = $this->currentUser()->hasPermission('administer simple_voting');
      $votes = $this->entityTypeManager()->getStorage('simple_voting')->loadMultiple();
      $results = [];

      foreach ($votes as $vote) {
        /** @var \Drupal\simple_voting\Entity\SimpleVotingInterface $vote */
        $question = $vote->getQuestion();
        $answer = $vote->getAnswer();
        $user_id = $vote->getUser()->id();

        if (!$is_admin && $user_id !== $this->currentUser()->id()) {
          continue;
        }

        $question_label = $question->label();
        if (!isset($results[$question_label])) {
          $results[$question_label] = [
            'question' => $question_label,
            'answers' => [],
          ];
        }

        if (!isset($results[$question_label]['answers'][$answer->label()])) {
          $results[$question_label]['answers'][$answer->label()] = 0;
        }

        $results[$question_label]['answers'][$answer->label()]++;
      }

      return new JsonResponse($results);
    } catch (Exception $e) {
      return new JsonResponse(['error' => 'An error occurred while fetching results.', 'details' => $e->getMessage()], 500);
    }
  }
}
