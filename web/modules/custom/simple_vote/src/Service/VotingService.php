<?php

namespace Drupal\simple_vote\Service;

use Drupal\simple_vote\Entity\Vote;
use Drupal\simple_vote\Entity\VotingQuestion;
use Drupal\simple_vote\Entity\VotingAnswer;

class VotingService {

  /**
   * Count total votes for a question.
   */
  public function getTotalVotesForQuestion($question_id) {
    $query = \Drupal::entityQuery('voting_record')
      ->condition('question_id', $question_id);
    return $query->count()->execute();
  }

  /**
   * Count votes per answer and calculate percentages.
   */
  public function getVotesByAnswer($question_id) {
    $answers = \Drupal::entityQuery('voting_answer')
      ->condition('question_id', $question_id)
      ->execute();
    
    $total_votes = $this->getTotalVotesForQuestion($question_id);
    $votes = [];
    
    foreach ($answers as $answer_id) {
      $count = \Drupal::entityQuery('voting_record')
        ->condition('answer_id', $answer_id)
        ->count()
        ->execute();
      
      $percentage = ($total_votes > 0) ? ($count / $total_votes) * 100 : 0;
      $votes[$answer_id] = [
        'count' => $count,
        'percentage' => round($percentage, 2),
      ];
    }
    return $votes;
  }
}
