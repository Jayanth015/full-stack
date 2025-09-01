<?php

namespace App\Controllers;

use App\Models\AuthUserModel;
use CodeIgniter\RESTful\ResourceController;

class Users extends ResourceController
{
    protected $authUserModel;

    public function __construct()
    {
        $this->authUserModel = new AuthUserModel();
    }

    public function index()
    {
        $users = $this->authUserModel->select('id, email, first_name, last_name, created_at, updated_at')->findAll();
        
        return $this->respond([
            'status' => 'success',
            'data' => $users
        ]);
    }

    public function show($id = null)
    {
        $user = $this->authUserModel->select('id, email, first_name, last_name, created_at, updated_at')->find($id);
        
        if (!$user) {
            return $this->failNotFound('User not found');
        }

        return $this->respond([
            'status' => 'success',
            'data' => $user
        ]);
    }
}
