<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\formatter\date_time;

use pvc\err\throwable\exception\pvc_exceptions\InvalidTypeException;
use pvc\formatter\date_time\FrmtrTimeShort;
use PHPUnit\Framework\TestCase;
use pvc\intl\err\InvalidTimezoneException;
use pvc\intl\Locale;
use pvc\intl\TimeZone;
use pvc\intl\UtcOffset;
use pvc\parser\date_time\time\ParserTimeShort;
use pvc\time\Time;

class FrmtrTimeShortTest extends TestCase
{

    /**
     * @function testFormat
     * @param string $locale
     * @param string $timeZone
     * @param string $expectedResult
     * @throws \pvc\intl\err\InvalidLocaleException
     * @throws \pvc\intl\err\UtcOffsetException
     * @dataProvider  dataProvider
     */
    public function testFormat(string $locale, string $timeZone, string $expectedResult) : void
    {
        $time = new Time((13 * 3600) + (32 * 60));

        $loc = new locale($locale);
        $utcOffset = new UtcOffset();
        $utcOffset->setUtcOffsetSeconds(0);
        $frmtr = new FrmtrTimeShort($loc, $utcOffset);

        self::assertEquals($expectedResult, $frmtr->format($time));
    }

    public function dataProvider() : array
    {
        return [
            'test US' => ['en_US', 'America/New_York', '1:32 pm'],
            'test FR' => ['fr_FR', 'Europe/Paris', '13:32'],
            // notice that the locale specifies a different separator for Canada
            'test CA' => ['en_CA', 'America/Toronto', '1:32 pm'],
        ];
    }

    public function testFormatChange() : void
    {
        $locale = new locale('en_US');
        $utcOffset = new UtcOffset();
        $utcOffset->setUtcOffsetSeconds(0);

        $time = new Time((13 * 3600) + (32 * 60));

        $frmtr = new FrmtrTimeShort($locale, $utcOffset);
        $frmtr->setFormat('H:i:s');
        $expectedResult = '13:32:00';
        self::assertEquals($expectedResult, $frmtr->format($time));
    }
}
