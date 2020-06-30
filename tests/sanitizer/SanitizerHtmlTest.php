<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\sanitizer;

use pvc\sanitizer\SanitizerHtml;
use PHPUnit\Framework\TestCase;

class SanitizerHtmlTest extends TestCase
{
    public function testSanitizeAngleBrackets() : void
    {
        $sanitizer = new SanitizerHtml();
        $string = 'some < > text containing & html entities';
        $expectedResult = 'some &lt; &gt; text containing &amp; html entities';
        self::assertEquals($expectedResult, $sanitizer->sanitize($string));
    }

    public function testSanitizeSingleQuotes() : void
    {
        $sanitizer = new SanitizerHtml();
        $string = "some text containing 'quoted text'";
        $expectedResult = 'some text containing &#039;quoted text&#039;';
        self::assertEquals($expectedResult, $sanitizer->sanitize($string));
    }

    public function testSanitizeDoubleQuotes() : void
    {
        $sanitizer = new SanitizerHtml();
        $string = 'some text containing "quoted text"';
        $expectedResult = 'some text containing &quot;quoted text&quot;';
        self::assertEquals($expectedResult, $sanitizer->sanitize($string));
    }
}
