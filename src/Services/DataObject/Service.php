<?php

declare(strict_types=1);

namespace Trimethylpentan\RaspiServicesToolBackend\Services\DataObject;

final class Service
{
    private string $service;
    private string $description;
    private Status $status;

    private function __construct(string $service, string $description, Status $status)
    {
        $this->service     = $service;
        $this->status      = $status;
        $this->description = $description;
    }

    public static function create(string $service, string $description, Status $status): self
    {
        return new self($service, $description , $status);
    }

    public function getService(): string
    {
        return $this->service;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
