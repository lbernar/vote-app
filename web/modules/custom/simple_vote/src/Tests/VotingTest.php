<?php

namespace Drupal\simple_vote\Tests;

use Drupal\simple_voting\Controller\VotingController;
use Drupal\simple_voting\Form\VotingForm;
use Drupal\simple_voting\Entity\Vote;
use Drupal\Tests\UnitTestCase;

/**
 * Tests the voting system functionality.
 */
class VotingTest extends UnitTestCase {

  /**
   * Tests the VotingController displayVotingQuestions method.
   */
  public function testDisplayVotingQuestions() {
    $controller = new VotingController();
    $result = $controller->displayVotingQuestions();
    $this->assertNotEmpty($result, 'Voting questions should not be empty.');
  }

  /**
   * Tests the VotingForm submission.
   */
  public function testSubmitVote() {
    $form = new VotingForm();
    $form_state = new \Drupal\Core\Form\FormState();
    $form_state->setValues(['question_id' => 1, 'option_id' => 2]);
    $form->submitForm($form_state);
    
    $this->assertTrue($form_state->get('submitted'), 'Vote should be submitted successfully.');
  }

  /**
   * Tests the Vote entity saving and retrieval.
   */
  public function testVoteEntity() {
    $vote = new Vote();
    $vote->setQuestionId(1);
    $vote->setOptionId(2);
    $vote->setUserId(3);
    $vote->save();

    $this->assertEquals(1, $vote->getQuestionId(), 'Question ID should match.');
    $this->assertEquals(2, $vote->getOptionId(), 'Option ID should match.');
    $this->assertEquals(3, $vote->getUserId(), 'User ID should match.');
  }

}