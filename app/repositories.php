<?php

declare(strict_types=1);

use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        'repositories' => [
            'redis' => [
                'host' => getenv('REDIS_HOST'),
                'port' => (int)getenv('REDIS_PORT'),
            ]
        ]
    ]);
};
