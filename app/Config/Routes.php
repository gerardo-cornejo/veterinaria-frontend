<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

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
