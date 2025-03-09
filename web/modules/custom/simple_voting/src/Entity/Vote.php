<?php

namespace Drupal\simple_voting\Entity;

use Drupal\Core\Entity\EntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityStorageInterface;

/**
 * Defines the Vote entity.
 *
 * @ContentEntityType(
 *   id = "vote",
 *   label = @Translation("Vote"),
 *   base_table = "votes",
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *   },
 *   handlers = {
 *     "storage" = "Drupal\Core\Entity\Sql\SqlContentEntityStorage",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\Core\Entity\EntityListBuilder",
 *     "form" = {
 *       "default" = "Drupal\simple_voting\Form\VoteForm",
 *     },
 *   },
 *   links = {
 *     "canonical" = "/vote/{vote}",
 *     "add-form" = "/vote/add",
 *     "edit-form" = "/vote/{vote}/edit",
 *     "delete-form" = "/vote/{vote}/delete",
 *     "collection" = "/admin/content/vote",
 *   },
 * )
 */
class Vote extends EntityBase {

  protected function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = [];

    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setReadOnly(TRUE);

    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setReadOnly(TRUE);

    $fields['question_id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Question ID'))
      ->setRequired(TRUE);

    $fields['option_id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Option ID'))
      ->setRequired(TRUE);

    $fields['user_id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('User ID'))
      ->setRequired(TRUE);

    return $fields;
  }

  public function saveVote() {
    // Logic to save the vote to the database.
  }

  public function getVoteData() {
    // Logic to retrieve vote data.
  }
}