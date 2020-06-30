<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\intl;

use IntlDateFormatter;

/**
 * Class DateTimePattern
 */
class DateTimePattern
{
    public static function getPatternDatePartsOrder(Locale $locale) : string
    {
        $frmtr = new IntlDateFormatter($locale->getLocale(), IntlDateFormatter::SHORT, IntlDateFormatter::NONE);
        $fmt = $frmtr->getPattern();
        // this returns a 'date parts order' template that the ParserDateShort object can use
        switch (strtolower(substr($fmt, 0, 1))) {
            case 'm':
                $result = 'mdy';
                break;
            case 'd':
                $result = 'dmy';
                break;
            // not sure that there are any short date formats in the Gregorian calendar that do not start with
            // 'm' or 'd' or 'y', so there's no code for any exception here.  Unrecognized formats fall into the
            // default category.
            case 'y':
            default:
                $result = 'ymd';
                break;
        }
        return $result;
    }

    public static function getPatternDateShort(Locale $locale) : string
    {
        $frmtr = new IntlDateFormatter($locale->getLocale(), IntlDateFormatter::SHORT, IntlDateFormatter::NONE);
        $fmt = $frmtr->getPattern();

        // convert to carbon / DateTime pattern

        // IntlDateFormatter M (months 1 - 12) => DateTime n
        // IntlDateFormatter MM (months 1 - 12) => DateTime m

        // IntlDateFormatter d (day of the month 0 - 31) => DateTime j
        // IntlDateFormatter dd (day of the month 0 - 31) => DateTime d

        // IntlDateFormatter yy (2 digit year, 80 / 20 rule) => DateTime y
        // IntlDateFormatter y  or yyyy (4 digit year) => DateTime Y

        switch (substr_count($fmt, 'M')) {
            case 2:
                $fmt = str_replace('MM', 'm', $fmt);
                break;
            case 1:
                $fmt = str_replace('M', 'n', $fmt);
                break;
        }

        switch (substr_count($fmt, 'd')) {
            case 2:
                $fmt = str_replace('dd', 'd', $fmt);
                break;
            case 1:
                $fmt = str_replace('d', 'j', $fmt);
                break;
        }

        switch (substr_count($fmt, 'y')) {
            case 2:
                $fmt = str_replace('yy', 'y', $fmt);
                break;
            case 1:
                $fmt = str_replace('y', 'Y', $fmt);
                break;
        }

        return $fmt;
    }

    public static function getPatternTimeShort(Locale $locale) : string
    {
        $frmtr = new IntlDateFormatter($locale->getLocale(), IntlDateFormatter::NONE, IntlDateFormatter::SHORT);
        $fmt = $frmtr->getPattern();
        // convert to carbon / DateTime pattern
        // IntlDateFormatter h (hours 1 - 12) => DateTime g
        // IntlDateFormatter mm (minutes 0 - 59) => DateTime i
        // IntlDateFormatter HH (hours 0 - 23) => DateTime H
        // IntlDateFormatter a (am / pm) => DateTime a (no translation necessary)
        $fmt = str_replace('h', 'g', $fmt);
        $fmt = str_replace('mm', 'i', $fmt);
        $fmt = str_replace('HH', 'H', $fmt);
        return $fmt;
    }

    public static function getPatternDateShortTimeShort(Locale $locale) : string
    {
        return self::getPatternDateShort($locale) . ' ' . self::getPatternTimeShort($locale);
    }
}
