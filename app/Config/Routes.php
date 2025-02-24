<?php
namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.


$routes->get('/home', 'Home::index');
$routes->get('/login', 'Login::index');
$routes->get('/register', 'Register::index');
$routes->get('/quien', 'Quien::index');
$routes->get('/mentiroso', 'Mentiroso::index');
$routes->get('/game', 'Game1::index');
$routes->post('/register', 'Register::register');
$routes->post('/login/auth', 'Login::autenticar');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/perfil', 'PerfilController::index');
$routes->get('subir', 'SubirController::index');
$routes->get('equipos/subir', 'EquiposController::subirImagen');
$routes->post('equipos/subir', 'EquiposController::subirImagen');
$routes->post('jugadores/subir', 'JugadoresController::subirImagen');
$routes->get('seleccion-equipos', 'EquiposController::vistaSeleccion');
$routes->get('api/buscarEquipos', 'EquiposController::buscarEquipos');
$routes->options('(:any)', function() {
    return service('response')
        ->setHeader('Access-Control-Allow-Origin', '*')
        ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE')
        ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');
});


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
