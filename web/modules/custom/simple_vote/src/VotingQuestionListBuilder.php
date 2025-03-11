<?php

namespace Drupal\simple_vote;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Url;

/**
 * Provides a list controller for the VotingQuestion entity with management options.
 */
class VotingQuestionListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('ID');
    $header['title'] = $this->t('Title');
    $header['identifier'] = $this->t('Identifier');
    $header['operations'] = $this->t('Operations');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /** @var \Drupal\simple_vote\Entity\VotingQuestion $entity */
    $row['id'] = $entity->id();
    $row['title'] = $entity->label();
    $row['identifier'] = $entity->get('identifier')->value;

    // Ensure entity has operations
    $operations = $this->getOperations($entity);
    if (!empty($operations)) {
      $row['operations'] = [
        'data' => [
          '#type' => 'operations',
          '#links' => $operations,
        ],
      ];
    }
    
    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  public function getOperations(EntityInterface $entity) {
    $operations = [];

    // Edit link
    $operations['edit'] = [
      'title' => $this->t('Edit'),
      'url' => Url::fromRoute('entity.voting_question.edit_form', ['voting_question' => $entity->id()]),
    ];

    // Delete link
    $operations['delete'] = [
      'title' => $this->t('Delete'),
      'url' => Url::fromRoute('entity.voting_question.delete_form', ['voting_question' => $entity->id()]),
    ];

    return $operations;
  }
}
