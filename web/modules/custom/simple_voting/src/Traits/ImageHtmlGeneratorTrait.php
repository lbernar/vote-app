<?php

declare(strict_types=1);

namespace Drupal\simple_voting\Traits;

use Drupal\file\Entity\File;

/**
 * Provides methods for generating image URLs.
 */
trait ImageHtmlGeneratorTrait {

  /**
   * Get the image URL.
   *
   * @param int|null $image_fid
   *   The file ID of the image.
   *
   * @return string
   *   The absolute URL of the image, or an empty string if not found.
   */
  protected function getImageUrl(?int $image_fid): string {
    if (!$image_fid) {
      return '';
    }

    $file = File::load($image_fid);
    if ($file) {
      return \Drupal::service('file_url_generator')->generateAbsoluteString($file->getFileUri());
    }

    return '';
  }

  /**
   * Generate HTML for the image.
   *
   * @param int|null $image_fid
   *   The file ID of the image.
   * @param string $alt_text
   *   The alt text for the image.
   *
   * @return string
   *   The HTML string for the image.
   */
  protected function generateImageHtml(?int $image_fid, string $alt_text): string {
    $image_url = $this->getImageUrl($image_fid);
    
    if (!$image_url) {
      return ''; // Return empty string if no image is found.
    }

    return '<img src="' . $image_url . '" alt="' . $alt_text . '" width="100px" height="100px" style="margin-right: 10px; vertical-align: middle;" />';
  }
}
