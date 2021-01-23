<?php

declare(strict_types=1);

namespace Trimethylpentan\RaspiServicesToolBackend\Users\ValueObject;

final class ProtectedRoutes
{
    private array $routes;

    private function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public static function from(array $routes): self
    {
        return new self($routes);
    }

    public function isProtected(string $route): bool
    {
        foreach ($this->routes as $protectedRoute) {
            if (preg_match('#' . $protectedRoute . '#', $route)) {
                return true;
            }
        }

        return false;
    }
}
