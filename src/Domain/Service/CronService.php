<?php

/**
 * Copyright (C) Senet Eindhoven B.V. - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Pim Jansen <pjansen@senet.nl>, <17-5-2019>
 */

declare(strict_types=1);

namespace Senet\Cron\Domain\Service;

use Cron\CronExpression;
use Psr\Log\LoggerInterface;
use Senet\Cron\Domain\Model\Cron;
use Senet\Cron\Infrastructure\Repositories\RepositoryInterface;
use Symfony\Component\Process\Process;

final class CronService
{
    private RepositoryInterface $repository;

    private LoggerInterface $logger;

    public function __construct(RepositoryInterface $repository, LoggerInterface $logger)
    {
        $this->repository = $repository;
        $this->logger = $logger;
    }

    public function execute(): void
    {
        $runningProcessCollection = new \ArrayIterator();
        foreach ($this->getExecutableCronCollection() as $cron) {
            $this->logger->info(
                sprintf(
                    'Starting cron runner (%s): %s',
                    $cron->getReference(),
                    $cron->getTask()
                )
            );

            $process = Process::fromShellCommandline($cron->getTask());
            $process->start();

            $runningProcessCollection->append($process);
            $this->logger->debug(
                sprintf('Registered process with PID: %s', $process->getPid())
            );

            $this->repository->flagCronAsExecuted($cron);
        }

        $this->logger->info(
            sprintf('Invoked %s jobs succesfully', $runningProcessCollection->count())
        );

        while ($runningProcessCollection->count() > 0) {
            /** @var Process $process */
            foreach ($runningProcessCollection as $key => $process) {
                // specific process is finished, so we remove it
                if ($process->isRunning() === false) {
                    $this->logger->info(
                        sprintf(
                            'Exited with (%s) and message: %s',
                            $process->getExitCode(),
                            $process->getErrorOutput()
                        )
                    );

                    $runningProcessCollection->offsetUnset($key);
                }
                $this->logger->debug(
                    sprintf('Process (%s) is still running', $process->getPid())
                );
                // check every second
                sleep(1);
            }
        }
    }

    /**
     * @return Cron[]
     */
    private function getExecutableCronCollection(): array
    {
        $cronCollection = [];
        foreach ($this->repository->getAllActiveCrons() as $cron) {
            if (CronExpression::factory($cron->getSchedule())->isDue()) {
                $cronCollection[] = $cron;
            }
        }

        return $cronCollection;
    }

    public function toggleCron(string $reference, bool $status): void
    {
        $this->repository->toggleCronByReference($reference, $status);
    }
}
