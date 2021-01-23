<?php
declare(strict_types=1);

use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $mariadbCredentials = include __DIR__ . '/credentials/mariadb.php';
    // Global Settings Object
    $containerBuilder->addDefinitions([
        'settings' => [
            'displayErrorDetails' => APP_ENV === 'testing',
            'redis' => [
                'host' => '127.0.0.1',
                'port' => 16379
            ],
            'mariadb' => [
                'host'     => '127.0.0.1',
                'port'     => 13306,
                'database' => 'raspi_services_tool',
                'user' => $mariadbCredentials['user'],
                'password' => $mariadbCredentials['password'],
            ],
            'protectedRoutes' => [
                '/api/.*'
            ]
        ],
    ]);
};
