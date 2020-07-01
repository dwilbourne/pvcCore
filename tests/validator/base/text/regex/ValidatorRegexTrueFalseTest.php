<?php
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version 1.0
 */

namespace tests\validator\base\text\regex;

use pvc\regex\err\RegexPatternUnsetException;
use pvc\validator\base\text\regex\ValidatorRegexTrueFalse;
use PHPUnit\Framework\TestCase;

class ValidatorRegexTrueFalseTest extends TestCase
{
    protected ValidatorRegexTrueFalse $validator;

    /**
     * setUp
     */
    public function setUp() : void
    {
        $this->validator = new ValidatorRegexTrueFalse();
    }

    /**
     * testPattern
     * @param string $testString
     * @param bool $expectedResult
     * @throws RegexPatternUnsetException
     * @dataProvider dataProvider
     */
    public function testPattern(string $testString, bool $expectedResult) : void
    {
        $this->assertEquals($expectedResult, $this->validator->validate($testString));
    }

    /**
     * dataProvider
     * @return array
     */
    public function dataProvider() : array
    {
        return array(
            'lower case true - OK' => ['true', true],
            'upper case true - OK' => ['TRUE', true],
            'mixed case true - OK' => ['TrUe', true],
            'lower case false - OK' => ['false', true],
            'upper case false - OK' => ['FALSE', true],
            'mixed case falser - OK' => ['fAlSe', true],
            'some other string - not ok' => ['some string', false],
            'empty string not ok' => ['', false]
        );
    }

}
