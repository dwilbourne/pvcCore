<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\regex\alternation;

use Exception;
use PHPUnit\Framework\TestCase;
use pvc\err\throwable\exception\pvc_exceptions\OutOfContextMethodCallException;
use pvc\regex\alternation\RegexAlternationSimple;

/**
 * Class RegexAlternationSimpleTest
 */

class RegexAlternationSimpleTest extends TestCase
{
    protected RegexAlternationSimple $regex;

    public function setUp() : void
    {
        $this->regex = new RegexAlternationSimple();
    }

    /**
     * @function testPattern
     * @param string $testString
     * @param bool $expectedResult
     * @throws Exception
     *
     * @dataProvider dataProviderCaseSensitive
     */
    public function testPatternCaseSensitive(string $testString, bool $expectedResult) : void
    {
        $this->regex->addChoice('foo');
        $this->regex->addChoice('bar');
        $this->regex->addChoice('baz');
        $this->regex->setCaseSensitive(true);
        $pattern = $this->regex->makePattern();
        $this->regex->setpattern($pattern);

        $this->assertEquals($expectedResult, $this->regex->match($testString));
    }

    public function dataProviderCaseSensitive() : array
    {
        return array(
            'lower case foo - OK' => ['foo', true],
            'upper case FOO - bad' => ['FOO', false],
            'mixed case Foo - bad' => ['Foo', false],
            'lower case bar - OK' => ['bar', true],
            'upper case BAR - bad' => ['BAR', false],
            'mixed case bAR - bad' => ['bAR', false],
            'lower case baz - OK' => ['baz', true],
            'mixed case bAZ - bad' =>  ['bAZ',false],
            'other letters - bad' => ['RTOK', false],
            'numbers, punctuation - bad' => ['3476,<-)98', false],
            'right letters wrong order' => ['oof', false]
        );
    }


    /**
     * @function testPatternCaseInsensitive
     * @param string $testString
     * @param bool $expectedResult
     * @throws Exception
     *
     * @dataProvider dataProviderCaseInsensitive
     */
    public function testPatternCaseInsensitive(string $testString, bool $expectedResult) : void
    {
        $this->regex->addChoice('foo');
        $this->regex->addChoice('bar');
        $this->regex->addChoice('baz');
        $this->regex->setCaseSensitive(false);
        $pattern = $this->regex->makePattern();
        $this->regex->setpattern($pattern);

        $this->assertEquals($expectedResult, $this->regex->match($testString));
    }

    public function dataProviderCaseInsensitive() : array
    {
        return array(
            'lower case foo - OK' => ['foo', true],
            'upper case FOO - OK' => ['FOO', true],
            'mixed case Foo - OK' => ['Foo', true],
            'lower case bar - OK' => ['bar', true],
            'upper case BAR - OK' => ['BAR', true],
            'mixed case bAR - OK' => ['bAR', true],
            'any case bAZ - OK' =>  ['bAZ',true],
            'other letters - bad' => ['RTOK', false],
            'numbers, punctuation - bad' => ['3476,<-)98', false],
            'right letters wrong order' => ['oof', false]
        );
    }

    public function testIncompleteObjectConfiguration() : void
    {
        $this->expectException(OutOfContextMethodCallException::class);
        $z = $this->regex->makepattern();
    }
}
