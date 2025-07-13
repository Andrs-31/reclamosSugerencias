<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Admin routes
$routes->get('/dashboard', 'Admin::dashboard');
$routes->get('/reclamos', 'Admin::reclamosList');