<?php

namespace tests\validator\document\html\UnitTests;

use Exception;
use Mockery;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use pvc\msg\Msg;
use pvc\msg\UserMsg;
use pvc\validator\document\html\err\ServerException;
use pvc\validator\document\html\HttpClient;
use pvc\validator\document\html\Message;
use pvc\validator\document\html\Messages;
use pvc\validator\document\html\MessagesFilter;
use pvc\validator\document\html\ResponseParser;
use pvc\validator\document\html\ResponseValidator;
use pvc\validator\document\html\ValidatorHtml;

class ValidatorHtmlTest extends TestCase
{
    /** @phpstan-ignore-next-line */
    protected $messages;

    /** @phpstan-ignore-next-line */
    protected $messagesFilter;

    /** @phpstan-ignore-next-line */
    protected $client;

    /** @phpstan-ignore-next-line */
    protected $rv;

    /** @phpstan-ignore-next-line */
    protected $rp;

    /** @phpstan-ignore-next-line */
    protected $validator;

    protected string $fixturesDir;

    public function setUp() : void
    {
        // dirname gets the parent directory if the levels argument is omitted
        $this->fixturesDir = dirname(__DIR__) . '/fixtures/';

        $this->messages = Mockery::mock(Messages::class);

        $this->messagesFilter = Mockery::mock(MessagesFilter::class);
        $this->messagesFilter->shouldReceive('setFailureThreshold')->withAnyArgs();
        $this->messagesFilter->shouldReceive('setReportingLevel')->withAnyArgs();

        $this->rv = Mockery::mock(ResponseValidator::class);
        $this->rp = Mockery::mock(ResponseParser::class);
        $this->client = Mockery::mock(HttpClient::class);

        $this->validator = Mockery::mock(ValidatorHtml::class)->makePartial();
        $this->validator->setMessages($this->messages);
        $this->validator->setMessagesFilter($this->messagesFilter);
        $this->validator->setResponseValidator($this->rv);
        $this->validator->setResponseParser($this->rp);
        $this->validator->setClient($this->client);
    }

    public function testSetGetValidatorUrl() : void
    {
        $url = 'www.example.com';
        $this->client->shouldReceive('setValidatorUrl')->with($url);
        $this->client->shouldReceive('getValidatorUrl')->withNoArgs()->andReturn($url);
        $this->validator->setValidatorUrl($url);
        self::assertEquals($url, $this->validator->getValidatorUrl());
    }

    public function testSetGetMessages() : void
    {
        self::assertEquals($this->messages, $this->validator->getMessages());
    }

    public function testSetGetFailureThreshold() : void
    {
        $threshold = Message::MESSAGE_TYPE_WARNING;
        $this->validator->setFailureThreshold($threshold);
        $this->messagesFilter->expects('getFailureThreshold')->withNoArgs()->andReturns($threshold)->byDefault();
        self::assertEquals($threshold, $this->validator->getFailureThreshold());

        $threshold = Message::MESSAGE_TYPE_ERROR;
        $this->validator->setFailureThreshold($threshold);
        $this->messagesFilter->expects('getFailureThreshold')->withNoArgs()->andReturns($threshold);
        self::assertEquals($threshold, $this->validator->getFailureThreshold());
    }

    public function testSetGetReportingLevel() : void
    {
        $reportingLevel = Message::MESSAGE_TYPE_ALL;
        $this->validator->setReportingLevel($reportingLevel);
        $this->messagesFilter->expects('getReportingLevel')->withNoArgs()->andReturns($reportingLevel)->byDefault();
        self::assertEquals($reportingLevel, $this->validator->getReportingLevel());

        $reportingLevel = Message::MESSAGE_TYPE_ERROR | Message::MESSAGE_TYPE_WARNING;
        $this->validator->setReportingLevel($reportingLevel);
        $this->messagesFilter->expects('getReportingLevel')->withNoArgs()->andReturns($reportingLevel);
        self::assertEquals($reportingLevel, $this->validator->getReportingLevel());
    }

    public function testSetGetResponseValidator() : void
    {
        self::assertEquals($this->rv, $this->validator->getResponseValidator());
    }

    public function testSetGetResponseParser() : void
    {
        self::assertEquals($this->rp, $this->validator->getResponseParser());
    }

    public function testWillThrowServerExceptionOnServerFailure() : void
    {
        $input = 'foo';
        $this->validator->shouldReceive('configureRequest')->with($input);
        $this->client->shouldReceive('sendRequest')->andThrow(Exception::class);
        self::expectException(ServerException::class);
        $this->validator->validate($input);
    }

    public function testValidateResponseWillFailOnValidatorFailure() : void
    {
        $response = Mockery::mock(ResponseInterface::class);
        $msg = Mockery::mock(UserMsg::class);

        $this->rv->expects('validate')->with($response)->andReturnFalse();
        $this->rv->shouldReceive('getStatusCode')->withNoArgs()->andReturn('anything');
        $this->rv->expects('getErrMsg')->withNoArgs()->andReturns($msg);

        self::assertFalse($this->validator->validateResponse($response));
        self::assertEquals($msg, $this->validator->getErrMsg());
    }

    public function testValidateResponseWillFailOnParserFailure() : void
    {
        $responseBody = 'any old string';
        $response = Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('getBody')->withNoArgs()->andReturn($responseBody);

        $msg = Mockery::mock(UserMsg::class);

        $this->rv->shouldReceive('validate')->with($response)->andReturnTrue();

        $this->rp->shouldReceive('parse')->with($responseBody)->andReturnFalse();
        $this->rp->shouldReceive('getErrMsg')->withNoArgs()->andReturn($msg);

        self::assertFalse($this->validator->validateResponse($response));
        self::assertEquals($msg, $this->validator->getErrMsg());
    }

    public function testValidateResponseWillFailOrSucceedDependingOnFailureThreshold() : void
    {
        $responseBody = 'any old string';
        $response = Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('getBody')->withNoArgs()->andReturn($responseBody);

        $msg = Mockery::mock(UserMsg::class);

        $this->rv->shouldReceive('validate')->withAnyArgs()->andReturnTrue();
        $this->rp->shouldReceive('parse')->with($responseBody)->andReturnTrue();

        $this->messagesFilter->shouldReceive('exceedFailureThreshold')->withNoArgs()->andReturn(true)->byDefault();
        self::assertFalse($this->validator->validateResponse($response));

        $this->messagesFilter->shouldReceive('exceedFailureThreshold')->withNoArgs()->andReturn(false);
        self::assertTrue($this->validator->validateResponse($response));
    }

    public function testValidate() : void
    {
        $requestString = 'foo';
        $responseBody = 'any old string';
        $response = Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('getBody')->withNoArgs()->andReturn($responseBody);

        $this->rv->shouldReceive('validate')->withAnyArgs()->andReturnTrue();
        $this->rp->shouldReceive('parse')->with($responseBody)->andReturnTrue();
        $this->client->shouldReceive('sendRequest')->withNoArgs()->andReturn($response);

        $this->messagesFilter->shouldReceive('exceedFailureThreshold')->withNoArgs()->andReturn(false);
        $this->validator->shouldReceive('configureRequest')->with($requestString);
        $this->validator->shouldReceive('request')->withNoArgs()->andReturn($response);
        self::assertTrue($this->validator->validate($requestString));
    }
}
