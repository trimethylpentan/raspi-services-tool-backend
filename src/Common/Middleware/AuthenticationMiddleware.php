<?php

declare(strict_types=1);

namespace Trimethylpentan\RaspiServicesToolBackend\Common\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Http\Response;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Response as Psr7Response;
use Trimethylpentan\RaspiServicesToolBackend\Users\Exception\UserNotFoundException;
use Trimethylpentan\RaspiServicesToolBackend\Users\Repository\UserTokenRedisRepository;
use Trimethylpentan\RaspiServicesToolBackend\Users\ValueObject\ProtectedRoutes;

class AuthenticationMiddleware implements MiddlewareInterface
{
    private UserTokenRedisRepository $tokenRepository;
    private ProtectedRoutes $protectedRoutes;

    public function __construct(UserTokenRedisRepository $tokenRepository, ProtectedRoutes $protectedRoutes)
    {
        $this->tokenRepository = $tokenRepository;
        $this->protectedRoutes = $protectedRoutes;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->getMethod() !== 'OPTIONS' && $this->protectedRoutes->isProtected($request->getRequestTarget())) {
            $apiKey = $request->getHeader('API-Key');
            if (empty($apiKey)) {
                return $this->returnError('Header API-Key must be set');
            }

            $apiKey = array_shift($apiKey);
            try {
                $this->tokenRepository->getUserNameFromToken($apiKey);
            } catch (UserNotFoundException $exception) {
                return $this->returnError('Invalid authentication key. Maybe your session timed-out');
            }
        }

        return $handler->handle($request);
    }

    private function returnError(string $message): Response
    {
        return (new Response(new Psr7Response(), new StreamFactory()))
            ->withStatus(403)
            ->withJson(['errors' => $message]);
    }
}
