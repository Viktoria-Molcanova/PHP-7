<?php

use PHPUnit\Framework\TestCase;

class HandleEventsDaemonCommandTest extends TestCase
{
    public function testGetCurrentTime()
    {
        $handleEventsDaemonCommand = new \App\Commands\HandleEventsDaemonCommand(new \App\Application(dirname(__DIR__)));

        $result = $handleEventsDaemonCommand->getCurrentTime();

        self::assertNotEmpty($result);

        self::assertEquals(
            [
                date("i"),
                date("H"),
                date("d"),
                date("m"),
                date("w")
            ],
            $result
        );
    }

    public function testGetCurrentTimeInDifferentTimezone()
    {
        date_default_timezone_set('Europe/Moscow');
        $handleEventsDaemonCommand = new \App\Commands\HandleEventsDaemonCommand(new \App\Application(dirname(__DIR__)));

        $result = $handleEventsDaemonCommand->getCurrentTime();

        self::assertEquals(
            [
                date("i"),
                date("H"),
                date("d"),
                date("m"),
                date("w")
            ],
            $result
        );
    }
    public function testGetCurrentTimeAfterMidnight()
    {
        $mockTime = mktime(0, 1, 0, date("m"), date("d"), date("Y"));
        $handleEventsDaemonCommand = new \App\Commands\HandleEventsDaemonCommand(new \App\Application(dirname(__DIR__)));

        $result = $handleEventsDaemonCommand->getCurrentTime();

        self::assertEquals(
            [
                date("i", $mockTime),
                date("H", $mockTime),
                date("d", $mockTime),
                date("m", $mockTime),
                date("w", $mockTime)
            ],
            $result
        );
    }
}
