<?php

declare(strict_types=1);

namespace Trimethylpentan\RaspiServicesToolBackend\Users\ValueObject;

final class User
{
    private string $userName;
    private string $passwordHash;
    private ?string $accessToken;

    private function __construct(string $userName, string $passwordHash, ?string $accessToken)
    {
        $this->userName = $userName;
        $this->passwordHash = $passwordHash;
    }

    public static function createWithoutAccessToken(string $userName, string $passwordHash): self
    {
        return new self($userName, $passwordHash, null);
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    public function setAccessToken(?string $accessToken): void
    {
        $this->accessToken = $accessToken;
    }
}
