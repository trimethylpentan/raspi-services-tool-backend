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
use Trimethylpentan\RaspiServicesToolBackend\Services\Command\StopServiceCommand;

class ServiceStopHandler implements HandlerInterface
{
    private StopServiceCommand $stopServiceCommand;

    public function __construct(StopServiceCommand $stopServiceCommand)
    {
        $this->stopServiceCommand = $stopServiceCommand;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, array $params): ResponseInterface
    {
        /** @var ServerRequest $request */
        $body = $request->getBody()->getContents();
        ['service-name' => $serviceName, 'password' => $password] =
            json_decode($body, true, 512, JSON_THROW_ON_ERROR);

        try {
            $service = $this->stopServiceCommand->stopService($serviceName, $password);
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
