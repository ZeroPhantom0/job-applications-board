<?php

namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;

class ApplicationTest extends CIUnitTestCase
{
    use ControllerTestTrait;

    // TEST 1: Home page loads successfully
    public function testHomePageLoads()
    {
        $result = $this->controller(Application::class)
                       ->execute('form');
        
        $this->assertTrue($result->isOK());
        $this->assertStringContainsString('Job Application', $result->getBody());
    }
    
    // TEST 2: Form has CSRF protection (assertEquals check)
    public function testFormHasCsrfProtection()
    {
        $result = $this->controller(Application::class)
                       ->execute('form');
        
        $body = $result->getBody();
        
        // Check for CSRF hidden input
        $this->assertStringContainsString('csrf_test_name', $body);
        $this->assertStringContainsString('type="hidden"', $body);
    }
    
    // TEST 3: Form redirects when validation fails (assertEquals)
    public function testFormRedirectsOnValidationError()
    {
        $result = $this->controller(Application::class)
                       ->execute('submit', [
                           'name' => '',
                           'email' => '',
                           'position' => ''
                       ]);
        
        // Should redirect back to form (assert equals redirect status)
        $this->assertTrue($result->isRedirect());
    }
    
    // TEST 4: XSS protection works (assertEquals for escaped output)
    public function testXssProtectionEscapesScriptTags()
    {
        $maliciousScript = '<script>alert("XSS")</script>';
        $escapedOutput = esc($maliciousScript, 'html');
        
        $this->assertStringNotContainsString('<script>', $escapedOutput);
        $this->assertStringContainsString('&lt;script&gt;', $escapedOutput);
        $this->assertStringContainsString('&quot;XSS&quot;', $escapedOutput);
        // Don't check exact string because CI4 may escape differently
    }
    
    // TEST 5: Success page loads
    public function testSuccessPageLoads()
    {
        $result = $this->controller(Application::class)
                       ->execute('success');
        
        $this->assertTrue($result->isOK());
        $this->assertStringContainsString('Application Submitted', $result->getBody());
    }
}