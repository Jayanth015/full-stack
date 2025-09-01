<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $header = $request->getHeader('Authorization');
        if (!$header) {
            return service('response')->setJSON(['error' => 'Token required'])->setStatusCode(401);
        }

        $token = explode(' ', $header->getValue())[1] ?? null;
        if (!$token) {
            return service('response')->setJSON(['error' => 'Token required'])->setStatusCode(401);
        }

        try {
            $decoded = JWT::decode($token, new Key(getenv('JWT_SECRET') ?: 'your-secret-key', 'HS256'));
            $request->user = $decoded;
        } catch (Exception $e) {
            return service('response')->setJSON(['error' => 'Invalid token'])->setStatusCode(401);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
