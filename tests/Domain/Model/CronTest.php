<?php
declare(strict_types=1);

namespace Senet\Cron\Domain\Model;

use DateTime;
use PHPUnit\Framework\TestCase;
use Psr\Log\InvalidArgumentException;

/**
 * Class CronTest
 */
class CronTest extends TestCase
{
    private function getValidCronSchedule()
    {
        return '* * * * *';
    }
    public function testIdMapping()
    {
        $cron = new Cron(1, $this->getValidCronSchedule(), 'task', 'ref', new DateTime());
        $this->assertEquals($cron->getId(), 1);
    }

    public function testValidScheduleMapping()
    {
        $cron = new Cron(1, $this->getValidCronSchedule(), 'task', 'ref', new DateTime());
        $this->assertEquals($cron->getSchedule(), $this->getValidCronSchedule());
    }

    public function testInvalidScheduleMapping()
    {
        $this->expectException(InvalidArgumentException::class);
        new Cron(1, 'invalid', 'task', 'ref', new DateTime());
    }


    public function testRefereceMapping()
    {
        $cron = new Cron(1, $this->getValidCronSchedule(), 'task', 'ref', new DateTime());
        $this->assertEquals($cron->getReference(), 'ref');
    }

    public function testCreatedMapping()
    {
        $date = new DateTime();
        $cron = new Cron(1, $this->getValidCronSchedule(), 'task', 'ref', $date, new DateTime());
        $this->assertEquals($cron->getCreated(), $date);
    }

    public function testLastrunMapping()
    {
        $date = new DateTime();
        $cron = new Cron(1, $this->getValidCronSchedule(), 'task', 'ref', new DateTime(), $date);
        $this->assertEquals($cron->getLastrun(), $date);
    }

    public function testTaskMapping()
    {
        $cron = new Cron(1, $this->getValidCronSchedule(), 'task', 'ref', new DateTime());
        $this->assertEquals($cron->getTask(), 'task');
    }
}
