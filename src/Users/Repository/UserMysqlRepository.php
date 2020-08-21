<?php

declare(strict_types=1);

namespace Trimethylpentan\RaspiServicesToolBackend\Users\Repository;

use PDO;
use Trimethylpentan\RaspiServicesToolBackend\Users\Exception\UserNotFoundException;
use Trimethylpentan\RaspiServicesToolBackend\Users\ValueObject\User;

class UserMysqlRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getUser(string $userName): User
    {
        $query = 'SELECT * FROM users WHERE user_name = :userName';
        $statement = $this->pdo->prepare($query);
        $statement->execute(['userName' => $userName]);
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if (empty($user)) {
            throw new UserNotFoundException(sprintf('User with name %s was not found in database', $userName));
        }

        return User::createWithoutAccessToken($user['user_name'], $user['password_hash']);
    }
}
