<?php
// Database setup script
// This will create the database and tables if they don't exist

$host = 'localhost';
$username = 'root';
$password = '';

try {
    // Connect without specifying database first
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected to MySQL successfully\n";
    
    // Create database if it doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS teacher_auth_db";
    $pdo->exec($sql);
    echo "Database 'teacher_auth_db' created or already exists\n";
    
    // Select the database
    $pdo->exec("USE teacher_auth_db");
    
    // Create auth_user table
    $sql = "CREATE TABLE IF NOT EXISTS auth_user (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) UNIQUE NOT NULL,
        first_name VARCHAR(100) NOT NULL,
        last_name VARCHAR(100) NOT NULL,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);
    echo "Table 'auth_user' created or already exists\n";
    
    // Create teachers table
    $sql = "CREATE TABLE IF NOT EXISTS teachers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        university_name VARCHAR(255) NOT NULL,
        gender ENUM('Male', 'Female', 'Other') NOT NULL,
        year_joined INT NOT NULL,
        department VARCHAR(100) NOT NULL,
        phone VARCHAR(20),
        address TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES auth_user(id) ON DELETE CASCADE
    )";
    $pdo->exec($sql);
    echo "Table 'teachers' created or already exists\n";
    
    // Insert sample data if tables are empty
    $stmt = $pdo->query("SELECT COUNT(*) FROM auth_user");
    $userCount = $stmt->fetchColumn();
    
    if ($userCount == 0) {
        // Insert sample user
        $hashedPassword = password_hash('password123', PASSWORD_DEFAULT);
        $sql = "INSERT INTO auth_user (email, first_name, last_name, password) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['admin@example.com', 'Admin', 'User', $hashedPassword]);
        
        $userId = $pdo->lastInsertId();
        
        // Insert sample teacher
        $sql = "INSERT INTO teachers (user_id, university_name, gender, year_joined, department, phone, address) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId, 'Sample University', 'Male', 2020, 'Computer Science', '123-456-7890', '123 Main St, City']);
        
        echo "Sample data inserted successfully\n";
    } else {
        echo "Tables already contain data, skipping sample data insertion\n";
    }
    
    echo "Database setup completed successfully!\n";
    
} catch(PDOException $e) {
    echo "Database setup failed: " . $e->getMessage() . "\n";
}
?>
