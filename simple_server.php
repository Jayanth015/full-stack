<?php
// Simple PHP server for our teacher authentication API
// This bypasses the CodeIgniter framework requirements temporarily

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Data storage files
$users_file = 'data/users.json';
$teachers_file = 'data/teachers.json';

// Create data directory if it doesn't exist
if (!is_dir('data')) {
    mkdir('data', 0777, true);
}

// Initialize data files if they don't exist
if (!file_exists($users_file)) {
    file_get_contents($users_file) ?: file_put_contents($users_file, json_encode([]));
}
if (!file_exists($teachers_file)) {
    file_get_contents($teachers_file) ?: file_put_contents($teachers_file, json_encode([]));
}

// JWT configuration
$jwt_secret = 'your-super-secret-jwt-key-here-change-in-production';
$jwt_algorithm = 'HS256';

// Simple data storage functions
function loadData($file) {
    $data = file_get_contents($file);
    return $data ? json_decode($data, true) : [];
}

function saveData($file, $data) {
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
}

function generateId($data) {
    if (empty($data)) return 1;
    $maxId = max(array_column($data, 'id'));
    return $maxId + 1;
}

// Get request path and method
$request_uri = $_SERVER['REQUEST_URI'];
$path = parse_url($request_uri, PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Remove /api prefix if present and handle root path
$path = str_replace('/api', '', $path);
if ($path === '') $path = '/';

// Simple JWT functions
function generateJWT($payload) {
    global $jwt_secret;
    $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
    $payload = json_encode($payload);
    
    $base64Header = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
    $base64Payload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
    
    $signature = hash_hmac('sha256', $base64Header . "." . $base64Payload, $jwt_secret, true);
    $base64Signature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
    
    return $base64Header . "." . $base64Payload . "." . $base64Signature;
}

function verifyJWT($token) {
    global $jwt_secret;
    $parts = explode('.', $token);
    if (count($parts) !== 3) {
        return false;
    }
    
    $signature = hash_hmac('sha256', $parts[0] . "." . $parts[1], $jwt_secret, true);
    $base64Signature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
    
    return hash_equals($base64Signature, $parts[2]);
}

function getAuthUser() {
    $headers = getallheaders();
    if (!isset($headers['Authorization'])) {
        return false;
    }
    
    $auth = $headers['Authorization'];
    if (!preg_match('/Bearer\s+(.*)$/i', $auth, $matches)) {
        return false;
    }
    
    $token = $matches[1];
    if (!verifyJWT($token)) {
        return false;
    }
    
    // Decode payload (simplified)
    $parts = explode('.', $token);
    $payload = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $parts[1])), true);
    
    return $payload;
}

// Route handling
switch ($path) {
    case '/':
        echo json_encode([
            'message' => 'Teacher Management API is running!',
            'endpoints' => [
                'POST /auth/register' => 'Register a new user',
                'POST /auth/login' => 'Login user',
                'GET /users' => 'Get all users',
                'GET /teachers' => 'Get all teachers',
                'POST /teachers' => 'Create a new teacher with user account'
            ]
        ]);
        break;
        
    case '/auth/register':
        if ($method === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($input['email']) || !isset($input['password']) || !isset($input['first_name']) || !isset($input['last_name'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required fields']);
                exit;
            }
            
            $users = loadData($users_file);
            
            // Check if email already exists
            foreach ($users as $user) {
                if ($user['email'] === $input['email']) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Email already exists']);
                    exit;
                }
            }
            
            $newUser = [
                'id' => generateId($users),
                'email' => $input['email'],
                'password' => password_hash($input['password'], PASSWORD_DEFAULT),
                'first_name' => $input['first_name'],
                'last_name' => $input['last_name'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $users[] = $newUser;
            saveData($users_file, $users);
            
            echo json_encode([
                'message' => 'User registered successfully',
                'user_id' => $newUser['id']
            ]);
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
        }
        break;
        
    case '/auth/login':
        if ($method === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($input['email']) || !isset($input['password'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing email or password']);
                exit;
            }
            
            $users = loadData($users_file);
            $user = null;
            
            foreach ($users as $u) {
                if ($u['email'] === $input['email']) {
                    $user = $u;
                    break;
                }
            }
            
            if ($user && password_verify($input['password'], $user['password'])) {
                $token = generateJWT([
                    'user_id' => $user['id'],
                    'email' => $user['email'],
                    'exp' => time() + 3600
                ]);
                
                echo json_encode([
                    'message' => 'Login successful',
                    'token' => $token,
                    'user' => [
                        'id' => $user['id'],
                        'email' => $user['email'],
                        'first_name' => $user['first_name'],
                        'last_name' => $user['last_name']
                    ]
                ]);
            } else {
                http_response_code(401);
                echo json_encode(['error' => 'Invalid credentials']);
            }
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
        }
        break;
        
    case '/auth/profile':
        if ($method === 'GET') {
            $user = getAuthUser();
            if (!$user) {
                http_response_code(401);
                echo json_encode(['error' => 'Unauthorized']);
                exit;
            }
            
            $users = loadData($users_file);
            $userData = null;
            
            foreach ($users as $u) {
                if ($u['id'] == $user['user_id']) {
                    $userData = $u;
                    break;
                }
            }
            
            if ($userData) {
                echo json_encode([
                    'id' => $userData['id'],
                    'email' => $userData['email'],
                    'first_name' => $userData['first_name'],
                    'last_name' => $userData['last_name']
                ]);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'User not found']);
            }
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
        }
        break;
        
    case '/teachers':
        if ($method === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($input['email']) || !isset($input['password']) || !isset($input['first_name']) || !isset($input['last_name']) ||
                !isset($input['university_name']) || !isset($input['gender']) || !isset($input['year_joined']) || !isset($input['department'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required fields']);
                exit;
            }
            
            $users = loadData($users_file);
            $teachers = loadData($teachers_file);
            
            // Check if email already exists
            foreach ($users as $user) {
                if ($user['email'] === $input['email']) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Email already exists']);
                    exit;
                }
            }
            
            // Create user
            $newUser = [
                'id' => generateId($users),
                'email' => $input['email'],
                'password' => password_hash($input['password'], PASSWORD_DEFAULT),
                'first_name' => $input['first_name'],
                'last_name' => $input['last_name'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $users[] = $newUser;
            saveData($users_file, $users);
            
            // Create teacher
            $newTeacher = [
                'id' => generateId($teachers),
                'user_id' => $newUser['id'],
                'university_name' => $input['university_name'],
                'gender' => $input['gender'],
                'year_joined' => $input['year_joined'],
                'department' => $input['department'],
                'phone' => $input['phone'] ?? '',
                'address' => $input['address'] ?? '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $teachers[] = $newTeacher;
            saveData($teachers_file, $teachers);
            
            echo json_encode([
                'message' => 'Teacher created successfully',
                'user_id' => $newUser['id']
            ]);
        } elseif ($method === 'GET') {
            $users = loadData($users_file);
            $teachers = loadData($teachers_file);
            
            $result = [];
            foreach ($teachers as $teacher) {
                $user = null;
                foreach ($users as $u) {
                    if ($u['id'] == $teacher['user_id']) {
                        $user = $u;
                        break;
                    }
                }
                
                if ($user) {
                    $result[] = array_merge($teacher, [
                        'email' => $user['email'],
                        'first_name' => $user['first_name'],
                        'last_name' => $user['last_name']
                    ]);
                }
            }
            
            echo json_encode($result);
        } elseif ($method === 'DELETE') {
            // Handle teacher deletion
            $teacherId = isset($_GET['id']) ? (int)$_GET['id'] : null;
            if (!$teacherId) {
                http_response_code(400);
                echo json_encode(['error' => 'Teacher ID is required']);
                exit;
            }
            
            $teachers = loadData($teachers_file);
            $users = loadData($users_file);
            
            $teacherIndex = -1;
            $userId = null;
            
            foreach ($teachers as $index => $teacher) {
                if ($teacher['id'] == $teacherId) {
                    $teacherIndex = $index;
                    $userId = $teacher['user_id'];
                    break;
                }
            }
            
            if ($teacherIndex === -1) {
                http_response_code(404);
                echo json_encode(['error' => 'Teacher not found']);
                exit;
            }
            
            // Remove teacher
            array_splice($teachers, $teacherIndex, 1);
            saveData($teachers_file, $teachers);
            
            // Remove user
            $userIndex = -1;
            foreach ($users as $index => $user) {
                if ($user['id'] == $userId) {
                    $userIndex = $index;
                    break;
                }
            }
            
            if ($userIndex !== -1) {
                array_splice($users, $userIndex, 1);
                saveData($users_file, $users);
            }
            
            echo json_encode(['message' => 'Teacher deleted successfully']);
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
        }
        break;
        
    case '/users':
        if ($method === 'GET') {
            $users = loadData($users_file);
            
            // Remove password from response
            $safeUsers = [];
            foreach ($users as $user) {
                $safeUsers[] = [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    'created_at' => $user['created_at']
                ];
            }
            
            echo json_encode($safeUsers);
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
        }
        break;
        
    default:
        http_response_code(404);
        echo json_encode(['error' => 'Endpoint not found', 'path' => $path]);
        break;
}
