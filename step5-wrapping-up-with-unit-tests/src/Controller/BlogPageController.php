<?php

namespace Drupal\my_module\Controller;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\my_module\Repository\ArticleRepository;

class BlogPageController {

  use StringTranslationTrait;

  /**
   * @var \Drupal\my_module\Repository\ArticleRepository
   */
  private $articleRepository;

  /**
   * @var \Drupal\Core\Entity\EntityViewBuilderInterface
   */
  private $nodeViewBuilder;

  public function __construct(
    EntityTypeManagerInterface $entityTypeManager,
    ArticleRepository $articleRepository
  ) {
    $this->nodeViewBuilder = $entityTypeManager->getViewBuilder('node');
    $this->articleRepository = $articleRepository;
  }

  public function __invoke(): array {
    $build = [];

    $articles = $this->articleRepository->getAll();

    foreach ($articles as $article) {
      $build[] = $this->nodeViewBuilder->view($article, 'teaser');
    }

    return [
      '#markup' => render($build),
    ];
  }

}
