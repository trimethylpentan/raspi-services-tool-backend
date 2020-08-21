<?php

declare(strict_types=1);

namespace Trimethylpentan\RaspiServicesToolBackend\Users\Service;

use Trimethylpentan\RaspiServicesToolBackend\Users\Exception\InvalidPasswordException;
use Trimethylpentan\RaspiServicesToolBackend\Users\Exception\UserNotFoundException;
use Trimethylpentan\RaspiServicesToolBackend\Users\Repository\UserMysqlRepository;
use Trimethylpentan\RaspiServicesToolBackend\Users\Repository\UserTokenRedisRepository;
use Trimethylpentan\RaspiServicesToolBackend\Users\ValueObject\User;

class LoginService
{
    private UserMysqlRepository $userRepository;
    private UserTokenRedisRepository $tokenRepository;

    public function __construct(UserMysqlRepository $userRepository, UserTokenRedisRepository $tokenRepository)
    {
        $this->userRepository = $userRepository;
        $this->tokenRepository = $tokenRepository;
    }

    /**
     * @throws InvalidPasswordException
     * @throws UserNotFoundException
     */
    public function loginUser(string $userName, string $password): User
    {
        $user = $this->userRepository->getUser($userName);
        if (!password_verify($password, $user->getPasswordHash())) {
            throw new InvalidPasswordException('The given password is incorrect');
        }

        $this->tokenRepository->createAccessTokenForUser($user);

        return $user;
    }
}
