<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\sys;

use pvc\msg\MsgInterface;
use pvc\validator\sys\ValidatorUrl;
use PHPUnit\Framework\TestCase;

class ValidatorUrlTest extends TestCase
{
    protected ValidatorUrl $validator;

    public function setUp() : void
    {
        $this->validator = new ValidatorUrl();
    }

    public function testGetErrmsg() : void
    {
        $input = '9';
        self::assertFalse($this->validator->validate($input));
        self::assertTrue($this->validator->getErrMsg() instanceof MsgInterface);
    }

    /**
     * @function testBasic
     * @param string $url
     * @param bool $expectedResult
     * @dataProvider dataProvider
     */
    public function testBasic(string $url, bool $expectedResult) : void
    {
        // neither path nor query should be required
        self::assertEquals($expectedResult, $this->validator->validate($url));
    }

    public function dataProvider() : array
    {
        return [
          'basic url - no path or query' => ['http://www.example.com', true],
            'note that protocol is required' => ['www.example.com', false],
            'https is OK' => ['https://www.example.com', true],
            'ftp is OK' => ['ftp://www.example.com', true],
            'path is OK' => ['http://www.example.com/some/path', true],
            'query is OK' => ['http://www.example.com?foo=5', true],
            'path and query together ok' => ['http://www.example.com/path/to/somewhere?foo=5', true]
        ];
    }

    public function testPathIsRequired() : void
    {
        $this->validator->setPathRequired(true);
        $url = 'http://www.example.com';
        self::assertFalse($this->validator->validate($url));
        $url = 'http://www.example.com/some/path';
        self::assertTrue($this->validator->validate($url));
    }

    public function testQueryIsRequired() : void
    {
        $this->validator->setQueryRequired(true);
        $url = 'http://www.example.com';
        self::assertFalse($this->validator->validate($url));
        $url = 'http://www.example.com?foo=956';
        self::assertTrue($this->validator->validate($url));
    }
}
