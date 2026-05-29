<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;

class ApplicationModelTest extends CIUnitTestCase
{
    private $model;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new ApplicationModel();
    }
    
    // TEST 1: Validation passes with valid data
    public function testValidationPassesWithValidData()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'position' => 'Web Developer',
            'message' => 'I have 5 years experience',
            'resume_file' => 'resume_123.pdf'
        ];
        
        $result = $this->model->validate($data);
        
        $this->assertTrue($result);
    }
    
    // TEST 2: Validation fails with empty name (assertEquals)
    public function testValidationFailsWithEmptyName()
    {
        $data = [
            'name' => '',
            'email' => 'john@example.com',
            'position' => 'Web Developer',
            'resume_file' => 'resume.pdf'
        ];
        
        $result = $this->model->validate($data);
        
        $this->assertFalse($result);
        
        $errors = $this->model->errors();
        $expectedErrorMessage = 'Full name is required';
        
        $this->assertEquals($expectedErrorMessage, $errors['name'] ?? '');
    }
    
    // TEST 3: Validation fails with invalid email (assertEquals)
    public function testValidationFailsWithInvalidEmail()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'not-an-email',
            'position' => 'Web Developer',
            'resume_file' => 'resume.pdf'
        ];
        
        $result = $this->model->validate($data);
        
        $this->assertFalse($result);
        
        $errors = $this->model->errors();
        $expectedErrorMessage = 'Please enter a valid email address';
        
        $this->assertEquals($expectedErrorMessage, $errors['email'] ?? '');
    }
    
    // TEST 4: Validation fails with short name (min_length rule)
    public function testValidationFailsWithShortName()
    {
        $data = [
            'name' => 'Z',
            'email' => 'zen@example.com',
            'position' => 'Web Developer',
            'resume_file' => 'resume.pdf'
        ];
        
        $result = $this->model->validate($data);
        
        $this->assertFalse($result);
        
        $errors = $this->model->errors();
        $this->assertArrayHasKey('name', $errors);
    }
    
    // TEST 5: Model table name is correct (assertEquals)
    public function testModelTableNameIsCorrect()
    {
        $tableName = $this->model->getTable();
        
        $this->assertEquals('applications', $tableName);
    }
    
    // TEST 6: Model allowed fields are correct
    public function testModelAllowedFields()
    {
        $allowedFields = $this->model->allowedFields;
        
        $expectedFields = ['name', 'email', 'position', 'message', 'resume_file'];
        
        foreach ($expectedFields as $field) {
            $this->assertContains($field, $allowedFields);
        }
    }
}