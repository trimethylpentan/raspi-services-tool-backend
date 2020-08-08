<?php

use Middlewares\Whoops;
use Slim\App;
use Slim\Exception\HttpNotFoundException;
use Trimethylpentan\RaspiServicesToolBackend\Common\Handler\NotFound404Handler;
use Whoops\Handler\JsonResponseHandler;
use Whoops\Run;

return function (App $app) {
    $errorMiddleware = $app->addErrorMiddleware(APP_ENV === 'testing', true, true);
    $errorMiddleware->setErrorHandler(
        HttpNotFoundException::class,
        NotFound404Handler::class,
        );

    $handler = new JsonResponseHandler();
    $handler->addTraceToOutput(true);

    $whoopsRun = new Run();
    $whoopsRun->pushHandler($handler);

    $whoopsMiddleware = new Whoops($whoopsRun);
    $app->addMiddleware($whoopsMiddleware);
};
