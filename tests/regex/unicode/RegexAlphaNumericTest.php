<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\regex\unicode;

use Exception;
use PHPUnit\Framework\TestCase;
use pvc\regex\unicode\RegexAlphaNumeric;

class RegexAlphaNumericTest extends TestCase
{

    protected RegexAlphaNumeric $regex;

    public function setUp(): void
    {
        $this->regex = new RegexAlphaNumeric();
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
            'basic test 1' => ['abc123', true],
            'basic test 2' => ['%^&', false],
            'test letter a by itself in unicode followed by 2 numbers' => [
                json_decode('"' . '\u0061' . '"') . '78',
                true
            ],
            'french letter a with grave accent using one codepoint succeeded by 2 numbers' => [
                json_decode(
                    '"' . '\u00E0' . '"'
                ) . '42',
                true
            ],
            'french letter a with grave accent using two codepoints' => [json_decode('"' . '\u0061\u0300' . '"'), true],
            'just the accent' => [json_decode('"' . '\u0300' . '"'), false]
        ];
    }
}
