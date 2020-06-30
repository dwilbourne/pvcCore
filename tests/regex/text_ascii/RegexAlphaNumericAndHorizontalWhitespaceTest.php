<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\regex\text_ascii;

use Exception;
use PHPUnit\Framework\TestCase;
use pvc\regex\text_ascii\RegexAlphaNumeric;
use pvc\regex\text_ascii\RegexAlphaNumericAndHorizontalWhitespace;

/**
 * Class RegexAlphabeticTest
 */
class RegexAlphaNumericAndHorizontalWhitespaceTest extends TestCase
{

    protected RegexAlphaNumericAndHorizontalWhitespace $regex;

    public function setUp(): void
    {
        $this->regex = new RegexAlphaNumericAndHorizontalWhitespace();
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

    public function dataProvider() : array
    {
        return [
            'lower case' => ['assgogdf', true],
            'upper case' => ['EUIRYOIUY', true],
            'mixed case' => ['UhRfTlkOP', true],
            'numbers OK' => ['UhUhio873HYjl', true],
            'only numbers OK' => ['18793648379', true],
            'punctuation no good' => ['UhgIhhiHGGF&*%)', false],
            'horizontal whitespace OK (spaces, tabs)' => [chr(040) . '96Hfu3' . chr(011), true],
            'vertical whitespace no good (form feed)' => ['hiH' . chr(12) . 'GGF', false],
        ];
    }
}
