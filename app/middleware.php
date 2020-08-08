<?php
declare(strict_types=1);

use Slim\App;
use Trimethylpentan\RaspiServicesToolBackend\Common\Middleware\CorsMiddleware;

return function (App $app) {
    $app->add(CorsMiddleware::class);
};
