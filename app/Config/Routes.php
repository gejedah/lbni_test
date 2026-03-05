<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
//
$routes->get('/sales_order/list', 'SoController::listByRequest');
$routes->get('/sales_order', 'SoController::list');
$routes->get('/sales_order/view/(:segment)', 'SoController::view/$1');
// $routes->get('/sales_order', 'SoController::index');
