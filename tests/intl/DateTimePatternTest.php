<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\intl;

use pvc\intl\DateTimePattern;
use PHPUnit\Framework\TestCase;
use pvc\intl\Locale;

class DateTimePatternTest extends TestCase
{

    /**
     * @function testGetPatternDatePartsOrder
     * @param string $localeString
     * @param string $expectedResult
     * @throws \pvc\intl\err\InvalidLocaleException
     * @dataProvider dataProvider
     */
    public function testGetPatternDatePartsOrder(string $localeString, string $expectedResult) : void
    {
        $locale = new locale($localeString);
        self::assertEquals($expectedResult, DateTimePattern::getPatternDatePartsOrder($locale));
    }

    public function dataProvider() : array
    {
        return [
            'USA goes month day year' => ['en_US', 'mdy'],
            'Germany goes day month year' => ['de_DE', 'dmy'],
            'Canada goes year month day' => ['en_CA', 'ymd']
        ];
    }

    /**
     * @function testGetPatternFromLocale
     * @param Locale $locale
     * @param string $expectedResult
     * @dataProvider localeProvider
     */
    public function testGetPatternTimeShort(Locale $locale, string $expectedResult) : void
    {
        self::assertEquals($expectedResult, DateTimePattern::getPatternTimeShort($locale));
    }

    public function localeProvider(): array
    {
        return [
            [new locale('en_US'), 'g:i a'],
            [new locale('de_DE'), 'H:i']
        ];
    }
}
