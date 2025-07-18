<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Admin routes
$routes->get('/dashboard', 'Admin::dashboard');

// Reclamos
$routes->get('/reclamos', 'Admin::reclamosList');
$routes->get('/reclamos/(:segment)', 'Admin::reclamosList/$1');
$routes->post('/reclamos/update', 'Admin::updateReclamo');
$routes->get('admin/reclamos/contar', 'Admin::obtenerReclamoCounts');

// Categorías
$routes->get('/categorias', 'Admin::categoriasList');
$routes->post('/categorias/save', 'Admin::saveCategoria'); 
$routes->get('/categorias/delete/(:num)', 'Admin::deleteCategoria/$1');

// Ciudadanos (Usuarios con rol_id = 1)
$routes->get('/ciudadanos', 'Admin::ciudadanosList');
$routes->post('/ciudadanos/save', 'Admin::saveCiudadano'); 

$routes->group('api', function($routes) {
    $routes->get('distritos/(:segment)', 'UbicacionController::getDistritos/$1');
    $routes->get('corregimientos/(:segment)/(:segment)', 'UbicacionController::getCorregimientos/$1/$2');
    
    // Nuevas rutas para el modal
    $routes->get('reclamos/(:num)', 'Admin::getReclamo/$1');
    $routes->get('reclamos/(:num)/comentarios', 'Admin::getComentarios/$1');
    $routes->post('reclamos/comentarios', 'Admin::agregarComentario');
});
