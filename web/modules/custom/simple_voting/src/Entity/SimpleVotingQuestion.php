<?php

declare(strict_types=1);

namespace Drupal\simple_voting\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the Simple Voting Question entity.
 *
 * @ContentEntityType(
 *   id = "simple_voting_question",
 *   label = @Translation("Simple Voting Question"),
 *   base_table = "simple_voting_question",
 *   storage = "Drupal\Core\Entity\Sql\SqlContentEntityStorage",
 *   handlers = {
 *     "list_builder" = "Drupal\simple_voting\SimpleVotingQuestionListBuilder",
 *     "form" = {
 *       "add" = "Drupal\simple_voting\Form\SimpleVotingQuestionForm",
 *       "edit" = "Drupal\simple_voting\Form\SimpleVotingQuestionForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     }
 *   },
 *   admin_permission = "administer simple_voting_question",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *   },
 *   links = {
 *     "canonical" = "/admin/simple-voting-question/{simple_voting_question}",
 *     "edit-form" = "/admin/simple-voting-question/{simple_voting_question}/edit",
 *     "delete-form" = "/admin/simple-voting-question/{simple_voting_question}/delete",
 *     "collection" = "/admin/simple-voting-question",
 *   }
 * )
 */
class SimpleVotingQuestion extends ContentEntityBase implements SimpleVotingQuestionInterface {

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type): array {
    $fields = parent::baseFieldDefinitions($entity_type);

    // Field for the title of the question.
    $fields['label'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Title'))
      ->setRequired(TRUE);

    // Field to control if results are allowed to be viewed after voting.
    $fields['allow_results_view'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Allow results view after voting'))
      ->setDefaultValue(FALSE);

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function isResultsViewAllowed(): bool {
    // Return the current value of the 'allow_results_view' field as a boolean.
    return (bool) $this->get('allow_results_view')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setResultsViewAllowed(bool $allowed): void {
    // Set the value of the 'allow_results_view' field.
    $this->set('allow_results_view', $allowed);
  }

  /**
   * {@inheritdoc}
   */
  public function getTitle(): string {
    // Return the title of the question (label field).
    return $this->get('label')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setTitle(string $title): void {
    // Set the title of the question (label field).
    $this->set('label', $title);
  }
}
