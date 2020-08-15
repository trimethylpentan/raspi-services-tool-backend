<?php

declare(strict_types=1);

namespace Trimethylpentan\RaspiServicesToolBackend\API\Handler;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;
use Slim\Http\ServerRequest;
use Trimethylpentan\RaspiServicesToolBackend\Common\Exception\ServiceException;
use Trimethylpentan\RaspiServicesToolBackend\Common\Exception\ValueException;
use Trimethylpentan\RaspiServicesToolBackend\Common\Handler\HandlerInterface;
use Trimethylpentan\RaspiServicesToolBackend\Services\Command\RestartServiceCommand;

class ServiceRestartHandler implements HandlerInterface
{
    private RestartServiceCommand $restartServiceCommand;

    public function __construct(RestartServiceCommand $restartServiceCommand)
    {
        $this->restartServiceCommand = $restartServiceCommand;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, array $params): ResponseInterface
    {
        /** @var ServerRequest $request */
        $body = $request->getBody()->getContents();
        ['service-name' => $serviceName, 'password' => $password] =
            json_decode($body, true, 512, JSON_THROW_ON_ERROR);

        try {
            $service = $this->restartServiceCommand->restartService($serviceName, $password);
            /** @var Response $response */
            return $response->withStatus(200)
                ->withJson([
                    'service' => [
                        'service-name' => $service->getService(),
                        'description'  => $service->getDescription(),
                        'status'       => $service->getStatus()->getValue(),
                    ]
                ]);
        }
        catch (ServiceException | ValueException $exception) {
            return $response->withStatus(500)
                ->withJson([
                    'errors' => [
                        $exception->getMessage(),
                    ]
                ]);
        }
    }
}
