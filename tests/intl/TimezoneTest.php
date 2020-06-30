<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\intl;

use Carbon\CarbonTimeZone;
use PHPUnit\Framework\TestCase;
use pvc\intl\err\InvalidTimezoneException;
use pvc\intl\TimeZone;

/**
 * Class TimezoneTest
 */
class TimezoneTest extends TestCase
{


    public function testConstructor() : void
    {
        $tzString = 'America/Los_Angeles';
        $tz = new timeZone($tzString);
        static::assertTrue($tz instanceof CarbonTimeZone);
    }

    public function testConstructorBad() : void
    {
        $tzString = 'foo/bar';
        $this->expectException(InvalidTimezoneException::class);
        $tz = new TimeZone($tzString);
    }

    public function testExists() : void
    {
        $tzString = 'America/Los_Angeles';
        self::assertTrue(TimeZone::exists($tzString));

        $tzString = 'foo/bar';
        self::assertFalse(TimeZone::exists($tzString));
    }
}
