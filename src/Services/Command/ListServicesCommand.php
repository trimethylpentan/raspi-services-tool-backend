<?php

declare(strict_types=1);

namespace Trimethylpentan\RaspiServicesToolBackend\Services\Command;

use Trimethylpentan\RaspiServicesToolBackend\Common\Exception\ValueException;
use Trimethylpentan\RaspiServicesToolBackend\Services\Collection\ServiceCollection;
use Trimethylpentan\RaspiServicesToolBackend\Services\DataObject\Service;
use Trimethylpentan\RaspiServicesToolBackend\Services\DataObject\Status;

class ListServicesCommand
{
    public function getAllServices(): ServiceCollection
    {
        $output = shell_exec('systemctl --type=service -a');
        return $this->parseOutput($output);
    }

    public function listService(string $serviceName): Service
    {
        $output = shell_exec(sprintf('systemctl list-units -a %s.service', $serviceName));
        $services = $this->parseOutput($output);

        $servicesArray = iterator_to_array($services);
        $service = array_shift($servicesArray);
        if (!$service) {
            throw new ValueException('Could not find service with name ' . $serviceName);
        }

        return $service;
    }

    private function parseOutput(string $output): ServiceCollection
    {
        $splitOutput = explode("\n", $output);
        $services = ServiceCollection::createEmpty();

        foreach ($splitOutput as $outputLine) {
            $outputLine = trim($outputLine, ' ');
            if (empty($outputLine)) {
                continue;
            }

            // Parse all columns and filter whitespaces
            $columns = explode(' ', $outputLine);
            $columns = array_filter($columns, fn(string $column) => !empty($column));
            $columns = array_values($columns);
            [$serviceName, , , $status] = $columns;

            if (strpos($serviceName, '.service') === false) {
                continue;
            }

            $serviceName = str_replace('.service', '', $serviceName);

            $description = '';
            $count = count($columns);
            for ($i = 4; $i < $count; $i++) {
                $description .= $columns[$i] . ' ';
            }

            $description = trim($description, ' ');

            switch ($status) {
                case 'running':
                    $services->addService(Service::create($serviceName, $description, Status::create(Status::RUNNING)));
                    break;
                case 'dead':
                case 'exited':
                    $services->addService(Service::create($serviceName, $description, Status::create(Status::STOPPED)));
                    break;
                default:
                    $services->addService(Service::create($serviceName, $description, Status::create(Status::UNKNOWN)));
            }
        }
        return $services;
    }
}
