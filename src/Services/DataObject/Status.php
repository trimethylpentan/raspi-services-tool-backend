<?php

declare(strict_types=1);

namespace Trimethylpentan\RaspiServicesToolBackend\Services\DataObject;

use ReflectionClass;
use Trimethylpentan\RaspiServicesToolBackend\Common\Exception\ValueException;

final class Status
{
    public const RUNNING = 'running';
    public const STOPPED = 'stopped';
    public const UNKNOWN = 'unknown';

    private string $status;

    private function __construct(string $status)
    {
        if (!in_array($status, (new ReflectionClass(self::class))->getConstants(), true)) {
            throw new ValueException(sprintf('Value "%s" is not a valid status', $status));
        }

        $this->status = $status;
    }

    public static function create(string $status): self
    {
        return new self($status);
    }

    public function getValue(): string
    {
        return $this->status;
    }
}
