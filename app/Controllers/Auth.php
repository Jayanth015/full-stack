<?php

namespace App\Controllers;

use App\Models\AuthUserModel;
use Firebase\JWT\JWT;
use CodeIgniter\RESTful\ResourceController;

class Auth extends ResourceController
{
    protected $authUserModel;

    public function __construct()
    {
        $this->authUserModel = new AuthUserModel();
    }

    public function register()
    {
        $rules = [
            'email' => 'required|valid_email|is_unique[auth_user.email]',
            'first_name' => 'required|min_length[2]|max_length[50]',
            'last_name' => 'required|min_length[2]|max_length[50]',
            'password' => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = [
            'email' => $this->request->getPost('email'),
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'password' => $this->authUserModel->hashPassword($this->request->getPost('password'))
        ];

        $userId = $this->authUserModel->insert($data);
        
        if ($userId) {
            $user = $this->authUserModel->find($userId);
            unset($user['password']);
            
            return $this->respondCreated([
                'status' => 'success',
                'message' => 'User registered successfully',
                'data' => $user
            ]);
        }

        return $this->failServerError('Failed to register user');
    }

    public function login()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->authUserModel->where('email', $email)->first();

        if (!$user || !$this->authUserModel->verifyPassword($password, $user['password'])) {
            return $this->failUnauthorized('Invalid email or password');
        }

        $payload = [
            'user_id' => $user['id'],
            'email' => $user['email'],
            'iat' => time(),
            'exp' => time() + (60 * 60 * 24) // 24 hours
        ];

        $token = JWT::encode($payload, getenv('JWT_SECRET') ?: 'your-secret-key', 'HS256');

        unset($user['password']);

        return $this->respond([
            'status' => 'success',
            'message' => 'Login successful',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ]);
    }

    public function profile()
    {
        $userId = $this->request->user->user_id;
        $user = $this->authUserModel->find($userId);
        
        if (!$user) {
            return $this->failNotFound('User not found');
        }

        unset($user['password']);

        return $this->respond([
            'status' => 'success',
            'data' => $user
        ]);
    }

    public function logout()
    {
        // In a real application, you might want to blacklist the token
        return $this->respond([
            'status' => 'success',
            'message' => 'Logged out successfully'
        ]);
    }
}
