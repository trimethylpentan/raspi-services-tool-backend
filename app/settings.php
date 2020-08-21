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
                'host' => 'localhost',
                'port' => 13679
            ],
            'mariadb' => [
                'host'     => 'localhost',
                'port'     => 13306,
                'database' => 'raspi_services_tool',
                'user' => $mariadbCredentials['user'],
                'password' => $mariadbCredentials['password'],
            ]
        ],
    ]);
};
