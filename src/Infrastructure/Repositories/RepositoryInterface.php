<?php

/**
 * Copyright (C) Senet Eindhoven B.V. - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Pim Jansen <pjansen@senet.nl>, <17-5-2019>
 */

declare(strict_types=1);

namespace Senet\Cron\Infrastructure\Repositories;

use Senet\Cron\Domain\Model\Cron;

interface RepositoryInterface
{
    /**
     * Return all the crons that have to be executed
     * This could be either open cronjobs or one time tasks
     *
     * @return Cron[]
     */
    public function getAllActiveCrons(): array;

    /**
     * Flag a given cron as being executed. This means that the runner
     * executed the task
     */
    public function flagCronAsExecuted(Cron $cron): Cron;

    public function toggleCronByReference(string $reference, bool $status): void;
}
