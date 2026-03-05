<?php
// Minimal public/index.php for CodeIgniter 4 (requires framework files present via Composer)
// Place project public document root to this folder when using Apache/Nginx.

// Path to the project's root directory
define('CI_ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);

// Use Composer autoload (make sure you've run `composer install`)
require_once CI_ROOT . 'vendor/autoload.php';

// Boot CodeIgniter
$app = Config\Services::renderer();
// Let CodeIgniter handle the request
$path = realpath(__DIR__ . '/..');
require_once SYSTEMPATH . 'bootstrap.php';
$app = Config\Services::codeigniter();
