-- Teacher Management System Database
-- Database: teacher_auth_db

-- Create database
CREATE DATABASE IF NOT EXISTS `teacher_auth_db`;
USE `teacher_auth_db`;

-- Create auth_user table
CREATE TABLE `auth_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create teachers table
CREATE TABLE `teachers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `university_name` varchar(100) NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `year_joined` int(4) NOT NULL,
  `department` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `auth_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insert sample data
INSERT INTO `auth_user` (`email`, `first_name`, `last_name`, `password`, `created_at`, `updated_at`) VALUES
('admin@example.com', 'Admin', 'User', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('john.doe@university.edu', 'John', 'Doe', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('jane.smith@college.edu', 'Jane', 'Smith', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW());

-- Insert sample teachers (password for all users is 'password')
INSERT INTO `teachers` (`user_id`, `university_name`, `gender`, `year_joined`, `department`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(2, 'University of Technology', 'male', 2020, 'Computer Science', '1234567890', '123 Main St, Tech City, TC 12345', NOW(), NOW()),
(3, 'State College', 'female', 2019, 'Mathematics', '0987654321', '456 Oak Ave, College Town, CT 67890', NOW(), NOW());
