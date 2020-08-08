<?php

declare(strict_types=1);

namespace Trimethylpentan\RaspiServicesToolBackend\Common\Handler;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Http\Response;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Request;
use Slim\Psr7\Response as Psr7Response;

class NotFound404Handler
{
    /**
     * @param Request $request
     * @param Response $response
     * @return ResponseInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __invoke(
        RequestInterface $request,
        HttpNotFoundException $exception,
        bool $displayErrorDetails
    ): ResponseInterface {
        $response = new Response(new Psr7Response(), new StreamFactory());

        $responseDetails = [];

        if ($displayErrorDetails) {
            $responseDetails = [
                'exception' => get_class($exception),
                'message' => $exception->getMessage(),
                'trace' => $exception->getTrace(),
            ];
        }

        return $response->withJson([
            'status' => 404,
            'errors' => [404 => 'not-found'],
            'response' => $responseDetails
        ], 404);
    }
}
