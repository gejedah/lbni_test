<?php
// Minimal CodeIgniter 3 front controller (index.php)
// Adjust $system_path if your CI system folder is in a different location.

define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');

if (defined('ENVIRONMENT')) {
    switch (ENVIRONMENT) {
        case 'development':
            error_reporting(-1);
            ini_set('display_errors', 1);
        break;

        default:
            error_reporting(0);
            ini_set('display_errors', 0);
        break;
    }
}

$system_path = 'system';
$application_folder = 'application';

// Resolve and validate system path
$system_path = rtrim($system_path, '/').'/';
if (!is_dir($system_path)) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo "Your system folder path does not appear to be set correctly.\n";
    exit(3);
}

// Path constants
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
define('FCPATH', __DIR__.DIRECTORY_SEPARATOR);
define('BASEPATH', str_replace('\\', '/', $system_path));
define('APPPATH', $application_folder . DIRECTORY_SEPARATOR);

// Load CodeIgniter core
require_once BASEPATH . 'core/CodeIgniter.php';
