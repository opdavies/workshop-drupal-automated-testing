<?php

namespace Drupal\my_module\Repository;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\node\Entity\Node;
use Drupal\node\NodeInterface;

class ArticleRepository {

  /**
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  private $nodeStorage;

  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->nodeStorage = $entityTypeManager->getStorage('node');
  }

  public function getAll(): array {
    $articles = $this->nodeStorage->loadByProperties([
      'status' => Node::PUBLISHED,
      'type' => 'article',
    ]);

    uasort($articles, function (NodeInterface $a, NodeInterface $b): bool {
      return $a->getCreatedTime() < $b->getCreatedTime();
    });

    return $articles;
  }

}
