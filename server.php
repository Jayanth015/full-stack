<?php
// Simple PHP server for CodeIgniter application
// This bypasses the intl extension requirement temporarily

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define constants
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);
define('SYSTEMPATH', __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'codeigniter4' . DIRECTORY_SEPARATOR . 'framework' . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR);
define('APPPATH', __DIR__ . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR);
define('WRITEPATH', __DIR__ . DIRECTORY_SEPARATOR . 'writable' . DIRECTORY_SEPARATOR);
define('ENVIRONMENT', 'development');

// Load the framework
require_once SYSTEMPATH . 'bootstrap.php';

// Start the application
$app = new \CodeIgniter\CodeIgniter(new \Config\Paths());
$app->run();
