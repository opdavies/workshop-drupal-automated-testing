<?php

namespace Drupal\Tests\my_module\Unit\Wrapper;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\my_module\Wrapper\ArticleWrapper;
use Drupal\node\NodeInterface;
use Drupal\Tests\UnitTestCase;

class ArticleWrapperTest extends UnitTestCase {

  private $time;

  protected function setUp() {
    $this->time = $this->createMock(TimeInterface::class);
  }

  /** @test */
  public function it_returns_the_article() {
    $article = $this->createMock(NodeInterface::class);
    $article->method('id')->willReturn(5);
    $article->method('bundle')->willReturn('article');

    $articleWrapper = new ArticleWrapper($this->time, $article);

    $this->assertInstanceOf(NodeInterface::class, $articleWrapper->getOriginal());
    $this->assertSame(5, $articleWrapper->getOriginal()->id());
    $this->assertSame('article', $articleWrapper->getOriginal()->bundle());
  }

  /** @test */
  public function it_throws_an_exception_if_the_node_is_not_an_article() {
    $this->expectException(\InvalidArgumentException::class);

    $page = $this->createMock(NodeInterface::class);
    $page->method('bundle')->willReturn('page');

    new ArticleWrapper($this->time, $page);
  }

  /**
   * @test
   * @dataProvider articleCreatedDateProvider
   */
  public function articles_created_less_than_3_days_ago_are_not_publishable(
    string $offset,
    bool $expected
  ) {
    $this->time->method('getRequestTime')->willReturn(
      (new \DateTime())->getTimestamp()
    );

    $article = $this->createMock(NodeInterface::class);
    $article->method('bundle')->willReturn('article');

    $article->method('getCreatedTime')->willReturn(
      (new \DateTime())->modify($offset)->getTimestamp()
    );

    $articleWrapper = new ArticleWrapper($this->time, $article);

    $this->assertSame($expected, $articleWrapper->isPublishable());
  }

  public function articleCreatedDateProvider() {
    return [
      ['-1 day', FALSE],
      ['-2 days 59 minutes', FALSE],
      ['-3 days', TRUE],
      ['-1 week', TRUE],
    ];
  }
}
