<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('/', 'Home::login');
$routes->get('dashboard', 'Admin::dashboard');
$routes->get('logout', 'Home::logout');
