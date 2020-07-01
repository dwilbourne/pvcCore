<?php
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version 1.0
 */

namespace tests\regex\alternation;

use pvc\regex\alternation\RegexTrueFalse;
use PHPUnit\Framework\TestCase;
use pvc\regex\err\RegexPatternUnsetException;

/**
 * Class RegexTrueFalseTest
 * @package tests\regex\alternation
 */
class RegexTrueFalseTest extends TestCase
{
    protected RegexTrueFalse $regex;

    /**
     * setUp
     */
    public function setUp() : void
    {
        $this->regex = new RegexTrueFalse();
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
        $this->assertEquals($expectedResult, $this->regex->match($testString));
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
