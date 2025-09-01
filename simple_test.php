<?php
echo "Testing basic server connectivity...\n";

// Test 1: Basic connection
echo "Test 1: Basic connection to localhost:8000\n";
$context = stream_context_create([
    'http' => [
        'timeout' => 5,
        'method' => 'GET'
    ]
]);

$response = @file_get_contents('http://localhost:8000/', false, $context);
if ($response !== false) {
    echo "✓ Server is responding\n";
    echo "Response: " . substr($response, 0, 200) . "...\n\n";
} else {
    echo "✗ Server is not responding\n";
    $error = error_get_last();
    echo "Error: " . ($error['message'] ?? 'Unknown error') . "\n\n";
}

// Test 2: Check if we can reach the server at all
echo "Test 2: Checking server availability\n";
$connection = @fsockopen('localhost', 8000, $errno, $errstr, 5);
if ($connection) {
    echo "✓ Port 8000 is open and accepting connections\n";
    fclose($connection);
} else {
    echo "✗ Cannot connect to port 8000\n";
    echo "Error: $errstr ($errno)\n";
}

echo "\nTest completed.\n";
?>
