<?php

use Psr\Container\ContainerInterface;
use Ratchet\App;
use Ratchet\Server\EchoServer;
use Trimethylpentan\RaspiServicesToolBackend\Websocket\Handler\SystemInformationHandler;

return static function (App $app, ContainerInterface  $container) {
    $app->route('/ws/echo', $container->get(EchoServer::class), ['*']);
    $app->route('/ws/system-information', $container->get(SystemInformationHandler::class), ['*']);
};
