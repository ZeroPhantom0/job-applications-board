<?php

namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;

class AdminTest extends CIUnitTestCase
{
    use ControllerTestTrait;
    
    // TEST 1: Login page loads
    public function testLoginPageLoads()
    {
        $result = $this->controller(Admin::class)
                       ->execute('login');
        
        $this->assertTrue($result->isOK());
        $this->assertStringContainsString('Admin Login', $result->getBody());
    }
    
    // TEST 2: Login page has CSRF protection
    public function testLoginPageHasCsrfProtection()
    {
        $result = $this->controller(Admin::class)
                       ->execute('login');
        
        $body = $result->getBody();
        
        $this->assertStringContainsString('csrf_test_name', $body);
    }
    
    // TEST 3: Login fails with wrong credentials
    public function testLoginFailsWithWrongCredentials()
    {
        $result = $this->controller(Admin::class)
                       ->execute('doLogin', [
                           'email' => 'wrong@example.com',
                           'password' => 'wrongpass'
                       ]);
        
        $this->assertTrue($result->isRedirect());
    }
    
    // TEST 4: Applications page redirects when not logged in (assertEquals)
    public function testApplicationsPageRequiresLogin()
    {
        // Clear any existing session
        session()->destroy();
        
        $result = $this->controller(Admin::class)
                       ->execute('applications');
        
        $this->assertTrue($result->isRedirect());
        $this->assertNotEquals(200, $result->getStatusCode());
    }
}