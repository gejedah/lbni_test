<?php
namespace Config;

use CodeIgniter\Config\BaseConfig;

$routes = Services::routes();

// Load system routing file first, so that the app and ENVIRONMENT can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

// App routes
$routes->get('so', 'SoController::index');
$routes->get('so/list', 'SoController::listByRequest');

// ...additional routes
