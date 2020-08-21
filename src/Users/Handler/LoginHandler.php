<?php

declare(strict_types=1);

namespace Trimethylpentan\RaspiServicesToolBackend\Users\Handler;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;
use Slim\Http\ServerRequest;
use Trimethylpentan\RaspiServicesToolBackend\Common\Handler\HandlerInterface;
use Trimethylpentan\RaspiServicesToolBackend\Users\Exception\InvalidPasswordException;
use Trimethylpentan\RaspiServicesToolBackend\Users\Exception\UserNotFoundException;
use Trimethylpentan\RaspiServicesToolBackend\Users\Service\LoginService;

class LoginHandler implements HandlerInterface
{
    private LoginService $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, array $params): ResponseInterface
    {
        /** @var ServerRequest $request */
        $body = $request->getBody()->getContents();
        ['user-name' => $userName, 'password' => $password] =
            json_decode($body, true, 512, JSON_THROW_ON_ERROR);

        /** @var Response $response */
        try {
            $user = $this->loginService->loginUser($userName, $password);
        } catch (InvalidPasswordException | UserNotFoundException $exception) {
            return $response->withStatus(401)
                ->withJson([
                    'success' => false,
                    'errors' => [
                        'Invalid user-credentials given'
                    ]
                ]);
        }

        return $response->withStatus(200)
            ->withJson([
                'success' => true,
                'token' => $user->getAccessToken()
            ]);
    }
}
