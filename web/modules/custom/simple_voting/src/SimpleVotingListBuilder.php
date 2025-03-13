<?php

declare(strict_types=1);

namespace Drupal\simple_voting;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

/**
 * Provides a listing of simple votings.
 */
final class SimpleVotingListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader(): array {
    $header['question_id'] = $this->t('Question');
    $header['answer_id'] = $this->t('Answer');
    $header['user_id'] = $this->t('User');
    $header['timestamp'] = $this->t('Timestamp');
    return $header;
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity): array {
    /** @var \Drupal\simple_voting\SimpleVotingInterface $entity */
    $row['question_id'] = $entity->getQuestion()->getTitle();
    $row['answer_id'] = $entity->getAnswer()->getTitle();
    $row['user_id'] = $entity->getUser()->getDisplayName();
    $row['timestamp'] = date("Y-m-d H:i:s", (int)$entity->getTimestamp());
    return $row;
  }

}
