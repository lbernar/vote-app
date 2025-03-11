<?php

namespace Drupal\simple_vote\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the Voting Question entity.
 *
 * @ContentEntityType(
 *   id = "voting_question",
 *   label = @Translation("Voting Question"),
 *   base_table = "voting_question",
 *   handlers = {
 *    "list_builder" = "Drupal\simple_vote\VotingQuestionListBuilder",
*     "form" = {
*       "add" = "Drupal\simple_vote\Form\VotingQuestionForm",
*       "edit" = "Drupal\simple_vote\Form\VotingQuestionForm",
*       "default" = "Drupal\simple_vote\Form\VotingQuestionForm",
*       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm"
*     }
 *   },
 *   entity_keys = {
 *    "id" = "id",
 *    "title" = "title",
 *    "identifier" = "identifier",
 *   },
 * )
 */
class VotingQuestion extends ContentEntityBase implements VotingQuestionInterface {
  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['title'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Title'))
      ->setRequired(TRUE);

    $fields['identifier'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Unique Identifier'))
      ->setRequired(TRUE)
      ->addConstraint('UniqueField', ['identifier']);

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getTitle(): string {
    return $this->get('title')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setTitle($title): void {
    $this->set('title', $title);
  }

  /**
   * {@inheritdoc}
   */
  public function getIdentifier(): string {
    return $this->get('identifier')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setIdentifier($identifier): void {
    $this->set('identifier', $identifier);
  }
}
