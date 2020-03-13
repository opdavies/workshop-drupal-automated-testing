<?php

namespace Drupal\Tests\my_module\Functional;

use Drupal\Tests\BrowserTestBase;
use Symfony\Component\HttpFoundation\Response;

class MyModuleTest extends BrowserTestBase {

  protected $defaultTheme = 'stark';

  /** @test */
  public function the_front_page_loads_for_anonymous_users() {
    $this->drupalGet('<front>');

    $this->assertResponse(Response::HTTP_OK);
  }

}
