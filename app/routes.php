<?php
declare(strict_types=1);

use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Trimethylpentan\RaspiServicesToolBackend\API\Handler\ServiceRestartHandler;
use Trimethylpentan\RaspiServicesToolBackend\API\Handler\ServicesListHandler;
use Trimethylpentan\RaspiServicesToolBackend\API\Handler\ServiceStartHandler;
use Trimethylpentan\RaspiServicesToolBackend\API\Handler\ServiceStopHandler;
use Trimethylpentan\RaspiServicesToolBackend\Users\Handler\LoginHandler;

return function (App $app) {
    $app->group('/api', function (Group $group) {
        $group->group('/services', function (Group $group) {
            $group->any('/list', ServicesListHandler::class);
            $group->post('/start', ServiceStartHandler::class);
            $group->post('/stop', ServiceStopHandler::class);
            $group->post('/restart', ServiceRestartHandler::class);
        });
    });
    $app->group('/users', function (Group $group) {
        $group->post('/login', LoginHandler::class);
    });
};
