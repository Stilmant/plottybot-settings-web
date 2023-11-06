<?php
// in case tested on a server, this will prevent the server from serving the file directly
// and instead, serve it through api.php
// php -S localhost:8080 router.php 

$requested = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Check if file exists, if it does, serve it directly
if (file_exists(__DIR__ . $requested)) {
    return false;  // Serve the requested resource as-is.
}

// Else, handle the request with api.php
require_once 'api.php';
