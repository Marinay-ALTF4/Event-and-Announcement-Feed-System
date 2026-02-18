<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('/', 'Home::login');
$routes->get('dashboard', 'Admin::dashboard');
$routes->group('admin', static function ($routes) {
	$routes->get('users', 'Admin::users');
	$routes->get('users/new', 'Admin::create');
	$routes->post('users', 'Admin::store');
	$routes->get('users/(:num)/edit', 'Admin::edit/$1');
	$routes->post('users/(:num)/update', 'Admin::update/$1');
	$routes->post('users/(:num)/delete', 'Admin::delete/$1');
});
$routes->get('logout', 'Home::logout');
