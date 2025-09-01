<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Auth routes
$routes->post('api/auth/register', 'Auth::register');
$routes->post('api/auth/login', 'Auth::login');

// Protected routes
$routes->group('api', ['filter' => 'auth'], function($routes) {
    $routes->get('auth/profile', 'Auth::profile');
    $routes->post('auth/logout', 'Auth::logout');
    
    // Teacher routes
    $routes->post('teachers', 'Teachers::create');
    $routes->get('teachers', 'Teachers::index');
    $routes->get('teachers/(:num)', 'Teachers::show/$1');
    $routes->put('teachers/(:num)', 'Teachers::update/$1');
    $routes->delete('teachers/(:num)', 'Teachers::delete/$1');
    
    // Users routes
    $routes->get('users', 'Users::index');
    $routes->get('users/(:num)', 'Users::show/$1');
});
