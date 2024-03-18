<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get("/", "Home::index");

$routes->group("usuario", function (RouteCollection $routes) {
    $routes->get('login', 'UsuarioController::login');
    $routes->get('listar', 'UsuarioController::listar');
});

$routes->group('panel', function (RouteCollection $routes) {
    $routes->get('/', 'PanelController::home');
    $routes->get('home', 'PanelController::home');
    $routes->get('clientes', 'PanelController::clientes');
    $routes->get('Ventas', 'PanelController::ventas');
    $routes->get('configuracion', 'PanelController::configuracion');
});
$routes->group('configuracion', function (RouteCollection $routes) {
    $routes->get('propiedades', 'ConfiguracionController::propiedades');
    $routes->get('veterinarios', 'ConfiguracionController::veterinarios');
    $routes->get('vacunas', 'ConfiguracionController::vacunas');
    $routes->get('productos', 'ConfiguracionController::productos');
});
