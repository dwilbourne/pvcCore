<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\time;

use PHPUnit\Framework\TestCase;
use pvc\time\Time;

class TimeTest extends TestCase
{

    protected Time $pt;

    public function setUp(): void
    {
        $this->pt = new time();
    }

    /**
     * @function testAddTime
     * @dataProvider dataProvider
     * @param int $input
     * @param int $expectedResult
     */
    public function testAddTime(int $input, int $expectedResult) : void
    {
        self::assertEquals($expectedResult, $this->pt->addTime($input)->getTimestamp());
    }

    public function dataProvider() : array
    {
        return [
            'basic test positive number' => [102000, 15600],
            'test negative number' => [-90000, 82800]
        ];
    }

    public function testConstruct() : void
    {
        self::assertEquals(0, $this->pt->getTimestamp());
    }
}
