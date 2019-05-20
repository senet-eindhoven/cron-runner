<?php

/**
 * Copyright (C) Senet Eindhoven B.V. - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Pim Jansen <pjansen@senet.nl>, <17-5-2019>
 */

declare(strict_types=1);

namespace Senet\Cron\Infrastructure\Repositories\Doctrine;

use DateTime;

interface CronEntityInterface
{
    public function setId(int $id): CronEntityInterface;

    public function getId(): ?int;

    public function setSchedule(string $schedule): CronEntityInterface;

    public function getSchedule(): ?string;

    public function setTask(string $task): CronEntityInterface;

    public function getTask(): string;

    public function setReference(string $reference): CronEntityInterface;

    public function getReference(): string;

    public function setCreated(DateTime $created): CronEntityInterface;

    public function getCreated(): DateTime;

    public function setLastRun(?DateTime $lastRun): CronEntityInterface;

    public function getLastRun(): ?DateTime;
}
