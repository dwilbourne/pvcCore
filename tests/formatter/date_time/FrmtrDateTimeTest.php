<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\formatter\date_time;

use Carbon\Carbon;
use pvc\err\throwable\exception\pvc_exceptions\InvalidTypeException;
use pvc\formatter\date_time\FrmtrDateShort;
use pvc\formatter\date_time\FrmtrDateShortTimeShort;
use PHPUnit\Framework\TestCase;
use pvc\intl\err\InvalidTimezoneException;
use pvc\intl\Locale;
use pvc\intl\TimeZone;

class FrmtrDateTimeTest extends TestCase
{

    /**
     * @function testFormat
     * @param string $locale
     * @param string $timeZone
     * @param string $expectedResult
     * @throws InvalidTimezoneException
     * @throws \pvc\intl\err\InvalidLocaleException
     * @dataProvider  dataProvider
     */
    public function testFormat(string $locale, string $timeZone, string $expectedResult) : void
    {
        $loc = new locale($locale);
        $tz = new timeZone($timeZone);

        $dateTimeString = '2002-05-20 14:44';

        $dt = new Carbon($dateTimeString, $tz);
        $frmtr = new FrmtrDateShortTimeShort($loc, $tz);

        self::assertEquals($expectedResult, $frmtr->format($dt));
    }

    public function dataProvider() : array
    {
        return [
            'test US' => ['en_US', 'America/New_York', '5/20/02 2:44 pm'],
            'test FR' => ['fr_FR', 'Europe/Paris', '20/05/2002 14:44'],
            // notice that the locale specifies a different separator for Canada
            'test CA' => ['en_CA', 'America/Toronto', '2002-05-20 2:44 pm'],
        ];
    }

    public function testFormatChange() : void
    {
        $locale = new locale('en_US');
        $timeZone = new timeZone('America/New_York');

        $dateTimeString = '2002-05-20 18:35';
        $dt = new Carbon($dateTimeString, new timeZone(($timeZone)));

        $frmtr = new FrmtrDateShortTimeShort($locale, $timeZone);
        $frmtr->setFormat('m/d/Y g:i a');
        $expectedResult = '05/20/2002 6:35 pm';
        self::assertEquals($expectedResult, $frmtr->format($dt));
    }
}
