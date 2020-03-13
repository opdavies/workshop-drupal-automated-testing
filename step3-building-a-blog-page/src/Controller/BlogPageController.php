<?php

namespace Drupal\my_module\Controller;

use Drupal\Core\StringTranslation\StringTranslationTrait;

class BlogPageController {

  use StringTranslationTrait;

  public function __invoke(): array {
    return [
      '#markup' => $this->t('Welcome to my blog!'),
    ];
  }

}
