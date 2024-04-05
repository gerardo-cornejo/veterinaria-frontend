<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get("/", "Home::index");

$routes->group("usuario", function (RouteCollection $routes) {
    $routes->get('login', 'UsuarioController::login');
    //$routes->get('listar', 'UsuarioController::listar');
    $routes->get('mi-perfil', 'UsuarioController::mi_perfil');
});

$routes->group('panel', function (RouteCollection $routes) {
    $routes->get('/', 'PanelController::home');
    $routes->get('home', 'PanelController::home');
    $routes->get('clientes', 'ClienteController::clientes');
    $routes->get('ventas', 'PanelController::ventas');
    $routes->get('configuracion', 'PanelController::configuracion');
});
$routes->group('configuracion', function (RouteCollection $routes) {
    $routes->get('propiedades', 'ConfiguracionController::propiedades');
    $routes->get('usuarios', 'ConfiguracionController::usuarios');
    $routes->get('vacunas', 'ConfiguracionController::vacunas');
    $routes->get('productos', 'ConfiguracionController::productos');
    $routes->get('suscripcion', 'ConfiguracionController::suscripcion');
});

