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

  /** @test */
  public function the_admin_page_is_not_accessible_to_anonymous_users() {
    $this->drupalGet('admin');

    $this->assertResponse(Response::HTTP_FORBIDDEN);
  }

  /** @test */
  public function the_admin_page_is_accessible_by_admin_users() {
    $adminUser = $this->createUser([
      'access administration pages',
    ]);

    $this->drupalLogin($adminUser);

    $this->drupalGet('/admin');

    $this->assertResponse(Response::HTTP_OK);
  }

}
