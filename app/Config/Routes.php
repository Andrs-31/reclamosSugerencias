<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//-----------------------------CAMBIOS DE JAFETHH

$routes->get('/', 'Login::index'); // PARA QUE LA PRIMERA PAGINA SEA LOGIN


$routes->setDefaultNamespace('App\Controllers'); // Establece el espacio de nombres predeterminado para los controladores

$routes->group('api', ['filter' => 'cors'], function($routes) {
    $routes->get('estadisticas', 'Api\Estadisticas::index');
    $routes->get('estadisticas/por-categoria', 'Api\Estadisticas::porCategoria');
    $routes->get('estadisticas/por-provincia', 'Api\Estadisticas::porProvincia');
    $routes->get('estadisticas/comentarios', 'Api\Estadisticas::totalComentarios');
});


$routes->get('register', 'Auth::register'); // Ruta para mostrar el formulario de registro
$routes->post('register', 'Auth::create'); // Ruta para procesar el registro
$routes->get('login', 'Login::index'); // Ruta para mostrar el formulario de inicio de sesión
$routes->post('login', 'Login::login'); // Ruta para procesar el inicio de sesión
$routes->get('logout', 'Login::logout'); // Ruta para cerrar sesión

$routes->get('admin/dashboard', 'Admin::dashboard', ['filter' => 'role:admin']); // Ruta para el dashboard del administrador
$routes->get('ciudadano/dashboard', 'Ciudadano::dashboard', ['filter' => 'role:ciudadano']); // Ruta para el dashboard del ciudadano


//UBICACIONES
// $routes->group('api', function($routes) {
//     $routes->get('distritos/(:segment)', 'UbicacionController::getDistritos/$1');
//     $routes->get('corregimientos/(:segment)/(:segment)', 'UbicacionController::getCorregimientos/$1/$2');
// });
//------------------------------CAMBIOS DE JAFETHH


//------------------------------RUTAS DE ADMINISTRADOR (ANDRES)
// Admin routes
$routes->get('/dashboard', 'Admin::dashboard', ['filter' => 'role:admin']);

// Reclamos
$routes->get('/reclamos', 'Admin::reclamosList', ['filter' => 'role:admin']);
$routes->get('/reclamos/(:segment)', 'Admin::reclamosList/$1', ['filter' => 'role:admin']);
$routes->get('/reclamos/usuario_id/(:num)', 'Admin::reclamosList/$1', ['filter' => 'role:admin']);
$routes->post('/reclamos/update', 'Admin::updateReclamo', ['filter' => 'role:admin']);
$routes->get('admin/reclamos/contar', 'Admin::obtenerReclamoCounts', ['filter' => 'role:admin']);

// Categorías
$routes->get('/categorias', 'Admin::categoriasList', ['filter' => 'role:admin']);
$routes->post('/categorias/save', 'Admin::saveCategoria', ['filter' => 'role:admin']); 
$routes->get('/categorias/delete/(:num)', 'Admin::deleteCategoria/$1', ['filter' => 'role:admin']);

// Ciudadanos (Usuarios con rol_id = 1)
$routes->get('/ciudadanos', 'Admin::ciudadanosList', ['filter' => 'role:admin']);
$routes->post('/ciudadanos/save', 'Admin::saveCiudadano', ['filter' => 'role:admin']); 

$routes->group('api', function($routes) {
    $routes->get('distritos/(:segment)', 'UbicacionController::getDistritos/$1');
    $routes->get('corregimientos/(:segment)/(:segment)', 'UbicacionController::getCorregimientos/$1/$2');
    
    // Nuevas rutas para el modal
    $routes->get('reclamos/(:num)', 'Admin::getReclamo/$1', ['filter' => 'role:admin']);
    $routes->get('reclamos/(:num)/comentarios', 'Admin::getComentarios/$1', ['filter' => 'role:admin']);
    $routes->post('reclamos/comentarios', 'Admin::agregarComentario', ['filter' => 'role:admin']);
});

//------------------------------FIN RUTAS DE ADMINISTRADOR (ANDRES)

//------------------------------RUTAS DE CIUDADANO (David)
// Ciudadano routes
$routes->get('/ciudadano/dashboard', 'Ciudadano::dashboard', ['filter' => 'role:ciudadano']);
$routes->get('/ciudadano/estadisticas', 'Ciudadano::estadisticas', ['filter' => 'role:ciudadano']);
$routes->get('/ciudadano/mis-reclamos', 'Ciudadano::misReclamos', ['filter' => 'role:ciudadano']);
$routes->get('/ciudadano/nuevo-reclamo', 'Ciudadano::nuevoReclamo', ['filter' => 'role:ciudadano']);
$routes->post('/ciudadano/guardar-reclamo', 'Ciudadano::guardarReclamo', ['filter' => 'role:ciudadano']);
$routes->get('/ciudadano/editar-reclamo/(:num)', 'Ciudadano::editarReclamo/$1', ['filter' => 'role:ciudadano']);
$routes->post('/ciudadano/actualizar-reclamo/(:num)', 'Ciudadano::actualizarReclamo/$1', ['filter' => 'role:ciudadano']);
$routes->post('/ciudadano/eliminar-reclamo/(:num)', 'Ciudadano::eliminarReclamo/$1', ['filter' => 'role:ciudadano']);
$routes->get('/ciudadano/ver-respuesta/(:num)', 'Ciudadano::verRespuesta/$1', ['filter' => 'role:ciudadano']);
$routes->post('/ciudadano/responder-comentario/(:num)', 'Ciudadano::responderComentario/$1', ['filter' => 'role:ciudadano']);
$routes->post('/ciudadano/marcar-solucionado/(:num)', 'Ciudadano::marcarSolucionado/$1', ['filter' => 'role:ciudadano']);
$routes->get('ciudadano/preguntas_frecuentes', 'Ciudadano::preguntas_frecuentes', ['filter' => 'role:ciudadano']);
$routes->get('ciudadano/tramites', 'Ciudadano::tramites', ['filter' => 'role:ciudadano']);
$routes->get('ciudadano/perfil', 'Ciudadano::perfil', ['filter' => 'role:ciudadano']);
$routes->post('ciudadano/actualizar-perfil', 'Ciudadano::actualizarPerfil', ['filter' => 'role:ciudadano']);
$routes->post('ciudadano/cambiar-password', 'Ciudadano::cambiarPassword', ['filter' => 'role:ciudadano']);
$routes->post('ciudadano/actualizar-notificaciones', 'Ciudadano::actualizarNotificaciones', ['filter' => 'role:ciudadano']);
$routes->post('ciudadano/actualizar-preferencias', 'Ciudadano::actualizarPreferencias', ['filter' => 'role:ciudadano']);
//------------------------------END RUTAS DE CIUDADANO (David)