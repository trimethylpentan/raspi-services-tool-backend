<?php

declare(strict_types=1);

namespace Trimethylpentan\RaspiServicesToolBackend\Common\Middleware\Factory;

use Psr\Container\ContainerInterface;
use Trimethylpentan\RaspiServicesToolBackend\Common\Middleware\AuthenticationMiddleware;
use Trimethylpentan\RaspiServicesToolBackend\Users\Repository\UserTokenRedisRepository;
use Trimethylpentan\RaspiServicesToolBackend\Users\ValueObject\ProtectedRoutes;

class AuthenticationMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): AuthenticationMiddleware
    {
        $tokenRepository = $container->get(UserTokenRedisRepository::class);
        $config          = $container->get('settings')['protectedRoutes'];
        $protectedRoutes = ProtectedRoutes::from($config);

        return new AuthenticationMiddleware($tokenRepository, $protectedRoutes);
    }
}
