<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Trimethylpentan\RaspiServicesToolBackend\Common\Client\Factory\PdoFactory;
use Trimethylpentan\RaspiServicesToolBackend\Common\Client\Factory\RedisClientFactory;
use Trimethylpentan\RaspiServicesToolBackend\Common\Middleware\AuthenticationMiddleware;
use Trimethylpentan\RaspiServicesToolBackend\Common\Middleware\Factory\AuthenticationMiddlewareFactory;
use function DI\factory;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        Redis::class => factory(RedisClientFactory::class),
        PDO::class   => factory(PdoFactory::class),

        AuthenticationMiddleware::class => factory(AuthenticationMiddlewareFactory::class)
    ]);
};
