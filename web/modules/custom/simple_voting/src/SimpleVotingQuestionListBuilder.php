<?php

declare(strict_types=1);

namespace Drupal\simple_voting;

use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Entity\EntityInterface;

/**
 * Provides a listing of simple voting questions.
 */
final class SimpleVotingQuestionListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader(): array {
    $header['label'] = $this->t('Title');
    $header['allow_results_view'] = $this->t('Allow Results View');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity): array {
    /** @var \Drupal\Core\Entity\EntityInterface $entity */
    $row['label'] = $entity->label();
    $row['allow_results_view'] = $entity->isResultsViewAllowed() ? $this->t('Allowed') : $this->t('Denied');
    return $row + parent::buildRow($entity);
  }

}
