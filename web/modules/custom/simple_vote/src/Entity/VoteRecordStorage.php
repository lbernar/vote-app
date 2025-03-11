<?php

namespace Drupal\simple_vote\Entity;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Entity\Query\QueryInterface;

/**
 * Defines the storage handler for Answer entities.
 */
class VoteRecordStorage extends SqlContentEntityStorage {

  /**
   * {@inheritdoc}
   */
  public function getQuery($conjunction = 'AND'): QueryInterface {
    return parent::getQuery();
  }

  /**
   * {@inheritdoc}
   */
  public function delete(array $entities) {
    parent::delete($entities);
  }

}