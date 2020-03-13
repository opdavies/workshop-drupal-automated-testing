<?php

namespace Drupal\my_module\Functional;

use Drupal\Tests\BrowserTestBase;
use Symfony\Component\HttpFoundation\Response;

class BlogPageTest extends BrowserTestBase {

  protected $defaultTheme = 'stark';

  protected static $modules = [
    'node',
    'my_module',
  ];

  /** @test */
  public function the_blog_page_loads_for_anonymous_users_and_contains_the_right_text() {
    $this->drupalGet('/blog');

    $session = $this->assertSession();

    $session->statusCodeEquals(Response::HTTP_OK);
    $session->responseContains('<h1>Blog</h1>');
  }

}
