<?php
// Simple API test script
echo "Testing Teacher Management API\n";
echo "=============================\n\n";

// Test 1: Check if server is running
echo "Test 1: Checking if server is running...\n";
$response = file_get_contents('http://localhost:8000/users');
if ($response !== false) {
    echo "✓ Server is running and responding\n";
    echo "Response: " . $response . "\n\n";
} else {
    echo "✗ Server is not responding\n\n";
}

// Test 2: Test user registration
echo "Test 2: Testing user registration...\n";
$data = [
    'email' => 'test@example.com',
    'password' => 'testpass123',
    'first_name' => 'Test',
    'last_name' => 'User'
];

$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/json',
        'content' => json_encode($data)
    ]
]);

$response = file_get_contents('http://localhost:8000/auth/register', false, $context);
if ($response !== false) {
    echo "✓ User registration successful\n";
    echo "Response: " . $response . "\n\n";
} else {
    echo "✗ User registration failed\n\n";
}

// Test 3: Test user login
echo "Test 3: Testing user login...\n";
$data = [
    'email' => 'test@example.com',
    'password' => 'testpass123'
];

$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/json',
        'content' => json_encode($data)
    ]
]);

$response = file_get_contents('http://localhost:8000/auth/login', false, $context);
if ($response !== false) {
    echo "✓ User login successful\n";
    echo "Response: " . $response . "\n\n";
} else {
    echo "✗ User login failed\n\n";
}

echo "API testing completed!\n";
?>
