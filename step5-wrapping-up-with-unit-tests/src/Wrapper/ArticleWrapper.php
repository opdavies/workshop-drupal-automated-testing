<?php

namespace Drupal\my_module\Wrapper;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\node\NodeInterface;

class ArticleWrapper {

  private $article;

  public function __construct(TimeInterface $time, NodeInterface $node) {
    $this->verifyNodeType($node);

    $this->time = $time;
    $this->article = $node;
  }

  public function getOriginal(): NodeInterface {
    return $this->article;
  }

  private function verifyNodeType(NodeInterface $node): void {
    if ($node->bundle() != 'article') {
      throw new \InvalidArgumentException(sprintf(
        '%s is not an article',
        $node->bundle()
      ));
    }
  }

  public function isPublishable(): bool {
    $created = $this->article->getCreatedTime();

    $difference = $this->time->getRequestTime() - $created;

    return $difference >= 60 * 60 * 24 * 3;
  }

}
