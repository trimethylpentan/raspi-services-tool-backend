<?php

declare(strict_types=1);

namespace Trimethylpentan\RaspiServicesToolBackend\Services\Collection;

use IteratorAggregate;
use JsonSerializable;
use Trimethylpentan\RaspiServicesToolBackend\Services\DataObject\Service;

class ServiceCollection implements IteratorAggregate, JsonSerializable
{
    /** @var Service[] */
    private array $services;

    private function __construct()
    {
    }

    public static function createEmpty(): self
    {
        $self = new self();
        $self->services = [];
        return $self;
    }

    public function addService(Service $service): void
    {
        $this->services[] = $service;
    }

    public function getIterator()
    {
        yield from $this->services;
    }

    public function jsonSerialize()
    {
        return array_map(
            fn(Service $service) => [
                'service-name' => $service->getService(),
                'description' => $service->getDescription(),
                'status' => $service->getStatus()->getValue()
            ],
            $this->services
        );
    }
}
