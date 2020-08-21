<?php

declare(strict_types=1);

namespace Trimethylpentan\RaspiServicesToolBackend\Users\Repository;

use Redis;
use Trimethylpentan\RaspiServicesToolBackend\Users\Exception\UserNotFoundException;
use Trimethylpentan\RaspiServicesToolBackend\Users\ValueObject\User;

class UserTokenRedisRepository
{
    private Redis $redis;

    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    public function createAccessTokenForUser(User $user, int $timeout = 3600): void
    {
        $key = bin2hex(random_bytes(32));
        $this->redis->set($key, $user->getUserName(), $timeout);
        $user->setAccessToken($key);
    }

    public function getUserNameFromToken(string $token): string
    {
        $userName = $this->redis->get($token);

        if ($userName === false) {
            throw new UserNotFoundException(sprintf('User with token %s not found in store.', $userName));
        }

        return $userName;
    }
}
