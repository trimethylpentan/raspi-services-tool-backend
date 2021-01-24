<?php

use DI\ContainerBuilder;
use Ratchet\App;

require __DIR__ . '/../vendor/autoload.php';

if (!defined('APP_ENV')) {
    define('APP_ENV', getenv('APP_ENV'));
}

$containerBuilder = new ContainerBuilder();

if (APP_ENV === 'production') {
    $containerBuilder->enableCompilation(__DIR__ . '/../var/cache');
}

// Set up settings
$settings = require __DIR__ . '/../app/settings.php';
$settings($containerBuilder);

// Set up dependencies
$dependencies = require __DIR__ . '/../app/dependencies.php';
$dependencies($containerBuilder);

// Set up repositories
$repositories = require __DIR__ . '/../app/repositories.php';
$repositories($containerBuilder);

// Build PHP-DI Container instance
$container = $containerBuilder->build();

// Run the server application through the WebSocket protocol on port 8081
$app = new App('localhost', 8081);

// Register routes
$routes = require __DIR__ . '/../app/websocket-routes.php';
$routes($app, $container);


$app->run();
