<?php

declare(strict_types=1);

namespace Trimethylpentan\RaspiServicesToolBackend\API\Handler;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;
use Trimethylpentan\RaspiServicesToolBackend\Common\Handler\HandlerInterface;
use Trimethylpentan\RaspiServicesToolBackend\Services\Command\ListServicesCommand;

class ServicesListHandler implements HandlerInterface
{
    private ListServicesCommand $servicesCommand;

    public function __construct(ListServicesCommand $servicesCommand)
    {
        $this->servicesCommand = $servicesCommand;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, array $params): ResponseInterface
    {
        $services = $this->servicesCommand->getAllServices();

        /** @var Response $response */
        $response->withStatus(200);
        return $response->withJson([
                'status' => 200,
                'services' => $services
            ]
        );
    }
}
