<?php
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version 1.0
 */

namespace tests\regex\alternation;

use PHPUnit\Framework\TestCase;
use pvc\regex\alternation\RegexYesNo;
use pvc\regex\err\RegexPatternUnsetException;

class RegexYesNoTest extends TestCase
{
    protected RegexYesNo $regex;

    /**
     * setUp
     */
    public function setUp() : void
    {
        $this->regex = new RegexYesNo();
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
            'lower case yes - OK' => ['yes', true],
            'upper case yes - OK' => ['YES', true],
            'mixed case yes - OK' => ['yEs', true],
            'lower case no - OK' => ['no', true],
            'upper case no - OK' => ['NO', true],
            'mixed case no - OK' => ['nO', true],
            'some other string - not ok' => ['some string', false],
            'empty string not ok' => ['', false]
        );
    }

}
