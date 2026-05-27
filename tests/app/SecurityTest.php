<?php

namespace App;

use CodeIgniter\Test\CIUnitTestCase;

class SecurityTest extends CIUnitTestCase
{
    // TEST 1: CSRF token is present in forms
    public function testCsrfTokenExists()
    {
        // Simulate the CSRF field generation
        $csrfField = csrf_field();
        
        $this->assertStringContainsString('csrf_test_name', $csrfField);
        $this->assertStringContainsString('hidden', $csrfField);
    }
    
    // TEST 2: esc() function properly escapes HTML
    public function testEscFunctionEscapesHtml()
    {
        $input = '<div onclick="alert(1)">Test</div>';
        $escaped = esc($input, 'html');
        
        $this->assertStringNotContainsString('<div', $escaped);
        $this->assertStringContainsString('&lt;div', $escaped);
    }
    
    // TEST 3: esc() function escapes JavaScript
    public function testEscFunctionEscapesJavaScript()
    {
        $input = '<script>alert("XSS")</script>';
        $escaped = esc($input, 'html');
        
        $this->assertStringNotContainsString('<script>', $escaped);
        $this->assertStringContainsString('&lt;script&gt;', $escaped);
    }
    
    // TEST 4: Admin credentials are not hardcoded in view (assertEquals)
    public function testAdminPasswordNotInView()
    {
        // Get login page content
        $controller = new \App\Controllers\Admin();
        $response = $controller->login();
        $body = method_exists($response, 'getBody') ? $response->getBody() : '';
        
        // Password should NOT appear in HTML
        $this->assertStringNotContainsString('admin123', $body);
        $this->assertStringNotContainsString('admin@jobsboard.com', $body);
    }
}