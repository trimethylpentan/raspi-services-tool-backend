<?php

declare(strict_types=1);

namespace Trimethylpentan\RaspiServicesToolBackend\Services\Command;

use Trimethylpentan\RaspiServicesToolBackend\Common\Exception\ServiceException;
use Trimethylpentan\RaspiServicesToolBackend\Common\Exception\ValueException;
use Trimethylpentan\RaspiServicesToolBackend\Services\DataObject\Service;

class StopServiceCommand
{
    private ListServicesCommand $listServiceCommand;

    public function __construct(ListServicesCommand $listServiceCommand)
    {
        $this->listServiceCommand = $listServiceCommand;
    }

    /**
     * @throws ServiceException
     * @throws ValueException
     */
    public function stopService(string $serviceName, string $password): Service
    {
        $result = shell_exec(sprintf('echo %s | sudo -S systemctl stop %s', $password, $serviceName));
        if (!$result) {
            return $this->listServiceCommand->listService($serviceName);
        }

        throw new ServiceException('Could not stop service with name ' . $serviceName);
    }
}
