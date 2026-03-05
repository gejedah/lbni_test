<?php
// router.php - simple router for PHP built-in webserver
// Usage: php -S localhost:8001 router.php

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$requested = __DIR__ . $uri;

// If the request corresponds to an existing file (css/js/images, etc.), let the built-in server serve it
if ($uri !== '/' && file_exists($requested) && is_file($requested)) {
    return false;
}

// Otherwise delegate to CodeIgniter front controller
require_once __DIR__ . '/index.php';
