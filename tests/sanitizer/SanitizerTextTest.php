<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\sanitizer;

use pvc\sanitizer\SanitizerText;
use PHPUnit\Framework\TestCase;

class SanitizerTextTest extends TestCase
{
    public function testSanitize() : void
    {
        $sanitizer = new SanitizerText();

        $escapeChar = chr(27);
        $tabChar = chr(9);
        $string = 'some ' . $escapeChar . 'text' . $tabChar;

        $expectedResult = 'some text';
        self::assertEquals($expectedResult, $sanitizer->sanitize($string));
    }
}
