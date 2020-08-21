<?php

declare(strict_types=1);

namespace Trimethylpentan\RaspiServicesToolBackend\Common\Client\Factory;

use Psr\Container\ContainerInterface;
use Redis;

class RedisClientFactory
{
    public function __invoke(ContainerInterface $container): Redis
    {
        $redis = new Redis();
        $config = $container->get('settings')['redis'];
        $redis->connect($config['host'], $config['port']);
        return $redis;
    }
}
