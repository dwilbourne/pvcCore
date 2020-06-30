<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\regex\unicode;

use Exception;
use PHPUnit\Framework\TestCase;
use pvc\regex\unicode\RegexAlphabetic;

class RegexAlphabeticTest extends TestCase
{

    protected RegexAlphabetic $regex;

    public function setUp(): void
    {
        $this->regex = new RegexAlphabetic();
    }


    /**
     * @function testPattern
     * @param string $subject
     * @param bool $expectedResult
     * @throws Exception
     *
     * @dataProvider dataProvider
     */
    public function testPattern(string $subject, bool $expectedResult) : void
    {
        static::assertEquals($expectedResult, $this->regex->match($subject));
    }

    public function dataProvider(): array
    {
        return [
            'basic test 1' => ['abc', true],
            'basic test 2' => ['123', false],
            'test letter a by itself in unicode' => [json_decode('"' . '\u0061' . '"'), true],
            'letter a with grave accent using one codepoint' => [json_decode('"' . '\u00E0' . '"'), true],
            'letter a with grave accent using two codepoints' => [json_decode('"' . '\u0061\u0300' . '"'), true],
            'just the accent' => [json_decode('"' . '\u0300' . '"'), false]
        ];
    }
}
