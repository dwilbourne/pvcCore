<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\regex\xml;

use Exception;
use PHPUnit\Framework\TestCase;
use pvc\regex\xml\RegexXMLElementName;

/**
 * Class RegexAlphabeticTest
 */
class RegexXMLElementNameTest extends TestCase
{


    protected RegexXMLElementName $regex;

    public function setUp(): void
    {
        $this->regex = new RegexXMLElementName();
    }

    public function testSingleElementName() : void
    {
        $subject = 'SomeElement';
        $expectedResult = true;
        static::assertEquals($expectedResult, $this->regex->match($subject));
    }

    /**
     * @function testPattern
     * @param string $subject
     * @param bool $expectedResult
     * @throws Exception
     *
     * @dataProvider dataProviderElementNames
     */

    public function testElementNames(string $subject, bool $expectedResult) : void
    {
        static::assertEquals($expectedResult, $this->regex->match($subject));
    }

    public function dataProviderElementNames() : array
    {
        return [
            'base case: name = SomeElement' => ['SomeElement', true],
            'cannot start with "xml"' => ['xmlElementName', false],
            'must start with an alpha (1)' => ['9Foo', false],
            'must start with an alpha (2)' => ['_Foo', false],
            'must start with an alpha (3)' => ['.Foo', false],
            'can contain underscores, hyphens, periods' => ['Some._-Name', true],
            'cannot contain whitespace' => ['some element name', false],
            'can contain digits' => ['some95elementsare_awesome', true]
        ];
    }
}
