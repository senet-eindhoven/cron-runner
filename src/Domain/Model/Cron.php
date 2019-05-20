<?php

/**
 * Copyright (C) Senet Eindhoven B.V. - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Pim Jansen <pjansen@senet.nl>, <17-5-2019>
 */

declare(strict_types=1);

namespace Senet\Cron\Domain\Model;

use Cron\CronExpression;
use DateTime;
use Psr\Log\InvalidArgumentException;

class Cron
{
    private int $id;

    private string $schedule;

    private string $task;

    private string $reference;

    private DateTime $created;

    private ?DateTime $lastRun;

    public function __construct(
        int $id,
        string $schedule,
        string $task,
        string $reference,
        DateTime $created,
        ?DateTime $lastRun = null
    ) {
        $this->id = $id;
        $this->schedule = $this->validateCronSchedule($schedule);
        $this->task = $task;
        $this->reference = $reference;
        $this->created = $created;
        $this->lastRun = $lastRun;
    }

    private function validateCronSchedule(string $schedule): string
    {
        if (CronExpression::isValidExpression($schedule) === false) {
            throw new InvalidArgumentException('Invalid cron schedule given');
        }

        return $schedule;
    }

    public function getTask(): string
    {
        return $this->task;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSchedule(): string
    {
        return $this->schedule;
    }

    public function getReference(): string
    {
        return $this->reference;
    }

    public function getCreated(): DateTime
    {
        return $this->created;
    }

    public function getLastRun(): ?DateTime
    {
        return $this->lastRun;
    }
}
