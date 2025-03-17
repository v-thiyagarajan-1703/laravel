<?php

// Start the request timer for performance monitoring
define('LARAVEL_START', microtime(true));

// Handle unexpected issues with maintenance mode
try {
    if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
        require $maintenance;
    }
} catch (Exception $e) {
    die('Maintenance mode is enabled, but an error occurred: ' . $e->getMessage());
}

// Register the Composer autoloader
if (!file_exists(__DIR__.'/../vendor/autoload.php')) {
    die('The vendor directory is missing. Run "composer install" to install dependencies.');
}
require __DIR__.'/../vendor/autoload.php';

// Bootstrap the Laravel application
try {
    /** @var Application $app */
    $app = require_once __DIR__.'/../bootstrap/app.php';

    // Handle the incoming HTTP request and send the response
    $app->handleRequest(Illuminate\Http\Request::capture());
} catch (Exception $e) {
    die('An error occurred while bootstrapping the application: ' . $e->getMessage());
}

