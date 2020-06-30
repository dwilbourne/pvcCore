<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\base\text\regex;

use pvc\validator\base\text\regex\ValidatorRegexAsciiLettersNumbers;
use PHPUnit\Framework\TestCase;

class ValidatorRegexAsciiLettersNumbersTest extends TestCase
{
    protected ValidatorRegexAsciiLettersNumbers $validator;

    public function setUp(): void
    {
        $this->validator = new ValidatorRegexAsciiLettersNumbers();
    }

    /**
     * @dataProvider dataProvider
     * @param string $string
     * @param bool $expectedResult
     */
    public function testValidator(string $string, bool $expectedResult) : void
    {
        self::assertEquals($expectedResult, $this->validator->validate($string));
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
            'whitespace no good' => ['  hiHGGF&*%)', false],
        ];
    }
}
