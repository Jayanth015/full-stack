<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthUserModel extends Model
{
    protected $table = 'auth_user';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['email', 'first_name', 'last_name', 'password', 'created_at', 'updated_at'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'email' => 'required|valid_email|is_unique[auth_user.email,id,{id}]',
        'first_name' => 'required|min_length[2]|max_length[50]',
        'last_name' => 'required|min_length[2]|max_length[50]',
        'password' => 'required|min_length[6]'
    ];

    protected $validationMessages = [
        'email' => [
            'required' => 'Email is required',
            'valid_email' => 'Please enter a valid email',
            'is_unique' => 'Email already exists'
        ],
        'first_name' => [
            'required' => 'First name is required',
            'min_length' => 'First name must be at least 2 characters',
            'max_length' => 'First name cannot exceed 50 characters'
        ],
        'last_name' => [
            'required' => 'Last name is required',
            'min_length' => 'Last name must be at least 2 characters',
            'max_length' => 'Last name cannot exceed 50 characters'
        ],
        'password' => [
            'required' => 'Password is required',
            'min_length' => 'Password must be at least 6 characters'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }
}
