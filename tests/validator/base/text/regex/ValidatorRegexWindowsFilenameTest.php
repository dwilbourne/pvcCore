<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\base\text\regex;

use pvc\regex\windows\RegexWindowsFilename;
use pvc\validator\base\text\regex\ValidatorRegexWindowsFilename;
use PHPUnit\Framework\TestCase;

class ValidatorRegexWindowsFilenameTest extends TestCase
{
    /**
     * @dataProvider dataProviderIllegalChars
     * @param string $subject
     * @param bool $allowFileExtension
     * @param bool $expectedResult
     * @throws \pvc\regex\err\RegexBadPatternException
     * @throws \pvc\regex\err\RegexPatternUnsetException
     */
    public function testIllegalChars(string $subject, bool $allowFileExtension, bool $expectedResult) : void
    {
        $regex = new RegexWindowsFilename($allowFileExtension);
        static::assertEquals($expectedResult, $regex->match($subject));
    }

    public function dataProviderIllegalChars() : array
    {
        return [
            'base case - all legals chars including period' => ['abc.txt', true, true],
            'less than sign' => ['a<c', true, false],
            'greater than sign' => ['a>c', true, false],
            'colon' => ['a:c', true, false],
            'doublequote' => ['a"c', true, false],
            'backslash' => ['a\\c', true, false],
            'frontslash' => ['a/c', true, false],
            'pipe' => ['a|c', true, false],
            'question mark' => ['a?c', true, false],
            'asterisk' => ['a*c', true, false],
            'multiple periods should be OK' => ['test..txt', true, true],
            'unless no periods are allowed' => ['test.txt', false, false],
        ];
    }
}
