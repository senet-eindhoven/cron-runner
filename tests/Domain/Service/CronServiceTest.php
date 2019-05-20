<?php
/**
 * Copyright (C) Senet Eindhoven B.V. - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Pim Jansen <pjansen@senet.nl>, <20-5-2019>
 */

declare(strict_types=1);

namespace Senet\Cron\Domain\Service;

use DateTime;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Senet\Cron\Domain\Model\Cron;
use Senet\Cron\Infrastructure\Repositories\RepositoryInterface;

class CronServiceTest extends TestCase
{
    public function testIfCronSchedulePickedup()
    {
        $logger = new NullLogger();
        $data = [
            new Cron(1, '* * * * *', 'ls', 'ref', new DateTime(), new DateTime())
        ];
        $repository = $this->createMock(RepositoryInterface::class);

        $repository->expects($this->once())
                   ->method('getAllActiveCrons')
                   ->willReturn($data);

        $repository->expects($this->once())
                   ->method('flagCronAsExecuted');

        $service = new CronService($repository, $logger);
        $service->execute();
    }
}
