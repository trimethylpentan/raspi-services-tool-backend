<?php

declare(strict_types=1);

namespace Trimethylpentan\RaspiServicesToolBackend\Websocket\Handler;

use DI\Annotation\Injectable;
use Exception;
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\MessageComponentInterface;
use React\EventLoop\LoopInterface;
use SplObjectStorage;

/**
 * @Injectable(lazy=true)
 */
class SystemInformationHandler implements MessageComponentInterface
{
    private SplObjectStorage $clients;
    private LoopInterface $loop;

    public function __construct(LoopInterface $loop)
    {
        $this->clients = new SplObjectStorage();
        $this->loop = $loop;
//        $this->loop->addPeriodicTimer(2, [$this, 'onLoop']);

    }

    public function onOpen(ConnectionInterface $connection): void
    {
        $this->clients->attach($connection);
        $connection->send('Successfully connected!');
        //TODO: The loop blocks the thread. Find out how to prevent this
        $this->loop->stop();
        $this->loop->run();
    }

    public function onClose(ConnectionInterface $connection): void
    {
        $connection->send('Closing connection');
        $this->clients->detach($connection);
    }

    public function onError(ConnectionInterface $connection, Exception $exception): void
    {
        $connection->close();
    }

    public function onMessage(ConnectionInterface $connection, MessageInterface $message): void
    {
        // Ignore Messages from clients
    }

    public function onLoop(): void
    {
        /** @var ConnectionInterface $client */
        foreach ($this->clients as $client) {
            $client->send('This is data!');
        }
    }
}
