<?php

declare(strict_types=1);

namespace Trimethylpentan\RaspiServicesToolBackend\Common\Handler;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface HandlerInterface
{
    public function __invoke(RequestInterface $request, ResponseInterface $response, array $params): ResponseInterface;
}
