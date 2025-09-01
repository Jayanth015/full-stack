<?php

// Ensure the current directory is pointing to the front controller's directory
chdir(__DIR__ . '/../../');

/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 * This process sets up the path constants, loads and registers
 * our autoloader, and loads our configuration file.
 */

// Load our paths config file
// This is the line that might be hard to find
$pathsConfig = new \Config\Paths();

// Location of the framework bootstrap file.
require rtrim($pathsConfig->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';

// Load environment settings from .env files into $_SERVER and $_ENV
require_once SYSTEMPATH . 'Config/DotEnv.php';
(new \CodeIgniter\Config\DotEnv(ROOTPATH))->load();

/*
 * ---------------------------------------------------------------
 * GRAB OUR CODEIGNITER INSTANCE
 * ---------------------------------------------------------------
 *
 * The CodeIgniter class contains the core functionality to make
 * the application run, and does all the dirty work to get
 * the threads all connected and organized.
 *
 * THOUGHT: It might be worth moving this class to a core
 * CodeIgniter class and extending it from there. This would
 * make it easier to override core functionality, and make
 * the inner workings of the system more transparent.
 */

$app = \Config\Services::codeigniter();
$app->initialize();
$app->run();
