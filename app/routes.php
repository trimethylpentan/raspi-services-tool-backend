<?php
declare(strict_types=1);

use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Trimethylpentan\RaspiServicesToolBackend\API\Handler\ServicesListHandler;

return static function (App $app) {
    $app->group('/api', function (Group $group) {
        $group->group('/services', function (Group $group) {
            $group->get('/list', ServicesListHandler::class);
        });
    });
};
