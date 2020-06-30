<?php

namespace tests\validator\document\html\UnitTests;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentException;
use pvc\validator\document\html\err\ResponseContentMsg;
use pvc\validator\document\html\err\ServerContentTypeMsg;
use pvc\validator\document\html\err\ServerStatusCodeNotOKMsg;
use pvc\validator\document\html\MessagesFilter;
use pvc\validator\document\html\ResponseParser;
use pvc\validator\document\html\ResponseValidator;

class ResponseValidatorTest extends TestCase
{
    protected ResponseValidator $rv;

    public function setUp() : void
    {
        $this->rv = new ResponseValidator();
    }

    public function testValidateBadArgumentException() : void
    {
        self::expectException(InvalidArgumentException::class);
        /** @phpstan-ignore-next-line */
        $this->rv->validate('foo');
    }

    /**
     * Ensure non-200 response fails
     */
    public function testWillFailNon200Reponse() : void
    {
        $responseMock = $this->getGuzzleResponseMock();
        $responseMock
            ->expects(static::any())
            ->method('getStatusCode')
            ->will(static::returnValue(500));
        self::assertFalse($this->rv->validate($responseMock));
        self::assertTrue($this->rv->getErrMsg() instanceof ServerStatusCodeNotOKMsg);
    }

    /**
     * Ensure response with a non-JSON content type fails
     */
    public function testWillFailOnNonJsonContentTypeResponse() : void
    {
        $responseMock = $this->getGuzzleResponseMock();
        $responseMock
            ->expects(static::any())
            ->method('getStatusCode')
            ->will(static::returnValue(200));

        $responseMock
            ->expects(static::any())
            ->method('getHeader')
            ->with(static::equalTo('Content-Type'))
            ->will(static::returnValue(['text/html']));

        self::assertFalse($this->rv->validate($responseMock));
        self::assertTrue($this->rv->getErrMsg() instanceof ServerContentTypeMsg);
    }

    /**
     * Ensure response with an invalid JSON body fails
     */
    public function testWillFailOnInvalidJsonResponse() : void
    {
        $responseMock = $this->getGuzzleResponseMock(true);
        $responseMock
            ->expects(static::any())
            ->method('getBody')
            ->will(static::returnValue('{"incompl'));

        self::assertFalse($this->rv->validate($responseMock));
        self::assertTrue($this->rv->getErrMsg() instanceof ResponseContentMsg);
    }

    /**
     * Ensure response with a valid JSON body passes
     */
    public function testWillSucceedOnValidResponse() : void
    {
        $responseMock = $this->getGuzzleResponseMock(true);
        $responseMock
            ->expects(static::any())
            ->method('getBody')
            ->will(static::returnValue('{"incomplete": "5"}'));

        self::assertTrue($this->rv->validate($responseMock));
        self::assertNull($this->rv->getErrMsg());
    }

    /**
     * Get a guzzle response mock
     *
     * @param boolean $expectSuccess Whether to prepare the mock with the default expectations
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    private function getGuzzleResponseMock($expectSuccess = false)
    {
        $mock = ($this->getMockBuilder('GuzzleHttp\Psr7\Response')
                      ->disableOriginalConstructor()
                      ->getMock());

        if ($expectSuccess) {
            $mock
                ->expects(static::any())
                ->method('getStatusCode')
                ->will(static::returnValue(200));

            $mock
                ->expects(static::any())
                ->method('getHeader')
                ->with(static::equalTo('Content-Type'))
                ->will(static::returnValue(['application/json']));
        }

        return $mock;
    }
}
