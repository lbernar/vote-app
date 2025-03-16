<?php

declare(strict_types=1);

namespace Drupal\simple_voting;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\file\Entity\File;

/**
 * Provides a listing of simple voting answers.
 */
final class SimpleVotingAnswerListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader(): array {
    $header['label'] = $this->t('Title');
    $header['question_id'] = $this->t('Question');
    $header['image'] = $this->t('Image');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity): array {
    /** @var \Drupal\simple_voting\Entity\SimpleVotingAnswerInterface $entity */
    
    $row['label'] = $entity->getTitle();
    $row['question_id'] = $entity->getQuestion()->getTitle();

    // Renderizar a imagem
    $image_fid = $entity->getImage();
    if (empty($image_fid)) {
      $row['image'] = $this->t('No image');
      return $row + parent::buildRow($entity);
    }
    $file = File::load($image_fid[0]);
    if(!$file) {
      $row['image'] = $this->t('No image');
      return $row + parent::buildRow($entity);
    }
      $image_url = \Drupal::service('file_url_generator')->generateAbsoluteString($file->getFileUri());
      $row['image'] = [
        '#theme' => 'image',
        '#uri' => $image_url,
        '#alt' => $entity->getTitle(),
        '#width' => 100,
        '#height' => 100,
        '#attributes' => ['style' => 'margin-bottom: 10px;'],
      ];
    
    return $row + parent::buildRow($entity);
  }
}
