<?php

namespace App\Models;

use CodeIgniter\Model;

class ApplicationModel extends Model
{
    protected $table = 'applications';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'name', 'email', 'position', 'message', 'resume_file', 'status'
    ];

    // Validation rules
    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[100]',
        'email' => 'required|valid_email|max_length[100]',
        'position' => 'required|max_length[100]',
        'message' => 'permit_empty|max_length[1000]',
        'resume_file' => 'required|max_length[255]'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Full name is required',
            'min_length' => 'Name must be at least 2 characters'
        ],
        'email' => [
            'required' => 'Email address is required',
            'valid_email' => 'Please enter a valid email address'
        ],
        'position' => [
            'required' => 'Position is required'
        ]
    ];

    protected $skipValidation = false;
    protected $createdField = 'created_at';
    protected $updatedField = '';
    protected $dateFormat = 'datetime';
}