<?php

declare(strict_types=1);

namespace Trimethylpentan\RaspiServicesToolBackend\Common\Client\Factory;

use PDO;
use Psr\Container\ContainerInterface;

class PdoFactory
{
    public function __invoke(ContainerInterface $container): PDO
    {
        $config = $container->get('settings')['mariadb'];
        $pdo = new PDO(
            sprintf('mysql:host=%s:%s;dbname=%s', $config['host'], $config['port'], $config['database']),
            $config['user'],
            $config['password']
//            'root',
//            'DpuGth+ckmV&mS2y'
        );

        return $pdo;
    }
}
