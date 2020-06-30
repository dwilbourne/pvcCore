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
use PHPUnit\Framework\TestCase;
use pvc\intl\err\InvalidTimezoneException;
use pvc\intl\Locale;
use pvc\intl\TimeZone;

class FrmtrDateShortTest extends TestCase
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

        $dateString = '2002-05-20';

        $dt = new Carbon($dateString, $tz);
        $frmtr = new FrmtrDateShort($loc, $tz);

        self::assertEquals($expectedResult, $frmtr->format($dt));
    }

    public function dataProvider() : array
    {
        return [
            'test US' => ['en_US', 'America/New_York', '5/20/02'],
            'test FR' => ['fr_FR', 'Europe/Paris', '20/05/2002'],
            // notice that the locale specifies a different separator for Canada
            'test CA' => ['en_CA', 'America/Toronto', '2002-05-20'],
        ];
    }

    public function testFormatChange() : void
    {
        $locale = new locale('en_US');
        $timeZone = new timeZone('America/New_York');

        $dateString = '2002-05-20';
        $dt = new Carbon($dateString, new timeZone(($timeZone)));

        $frmtr = new FrmtrDateShort($locale, $timeZone);
        $frmtr->setFormat('m/d/Y');
        $expectedResult = '05/20/2002';
        self::assertEquals($expectedResult, $frmtr->format($dt));
    }
}
