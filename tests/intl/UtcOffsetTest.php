<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\intl;

use pvc\intl\err\UtcOffsetException;
use pvc\intl\UtcOffset;
use PHPUnit\Framework\TestCase;

class UtcOffsetTest extends TestCase
{

    protected UtcOffset $utcOffset;

    public function setUp(): void
    {
        $this->utcOffset = new UtcOffset();
    }

    public function testSetGetTimezoneOffsetPositive() : void
    {
        $offsetSeconds = 18000;
        $this->utcOffset->setUtcOffsetSeconds($offsetSeconds);
        self::assertEquals('' . $offsetSeconds, $this->utcOffset->getUtcOffsetSeconds());
    }

    public function testSetGetTimezoneOffsetNegative() : void
    {
        $offsetSeconds = -18000;
        $this->utcOffset->setUtcOffsetSeconds($offsetSeconds);
        self::assertEquals('' . $offsetSeconds, $this->utcOffset->getUtcOffsetSeconds());
    }

    public function testSetSetTimezonOffsetTooSmall() : void
    {
        $offsetSeconds = -46800;
        self::expectException(UtcOffsetException::class);
        $this->utcOffset->setUtcOffsetSeconds($offsetSeconds);
    }

    public function testSetSetTimezonOffsetTooLarge() : void
    {
        $offsetSeconds = 54000;
        self::expectException(UtcOffsetException::class);
        $this->utcOffset->setUtcOffsetSeconds($offsetSeconds);
    }
}
