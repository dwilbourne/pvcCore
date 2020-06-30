<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\document\html\UnitTests;

use Mockery;
use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentException;
use pvc\validator\document\html\HttpClient;
use PHPUnit\Framework\TestCase;
use pvc\validator\document\xml\schema\Schema;

class HttpClientTest extends TestCase
{
    protected HttpClient $client;
    protected string $fixturesDir;

    public function setUp() : void
    {
        $this->client = new HttpClient();
        $this->fixturesDir  = dirname(__DIR__) . '/fixtures/';
    }

    public function testSetGetValidatorUrl() : void
    {
        $expectedResult = 'https://validator.nu';
        self::assertEquals($expectedResult, $this->client->getValidatorUrl());
        $url = 'www.checker.html.com';
        $this->client->setValidatorUrl($url);
        self::assertEquals($url, $this->client->getValidatorUrl());
    }

    public function testSetGetLoadXXE() : void
    {
        self::assertFalse($this->client->getLoadXXE());
        $this->client->loadXXE(true);
        self::assertTrue($this->client->getLoadXXE());
    }

    public function testAddGetSchemas() : void
    {
        $schema = Mockery::mock(Schema::class);
        $schema->shouldReceive('getNamespace')->withNoArgs()->andReturn('someNamespace');
        $this->client->addSchema($schema);
        self::assertEquals(1, count($this->client->getSchemas()));

        $schema_next = Mockery::mock(Schema::class);
        $schema_next->shouldReceive('getNamespace')->withNoArgs()->andReturn('someOtherNamespace');
        $this->client->addSchema($schema_next);
        self::assertEquals(2, count($this->client->getSchemas()));
    }

    public function testSetGetCheckErrorPages() : void
    {
        self::assertFalse($this->client->getCheckErrorPages());
        $this->client->setCheckErrorPages(true);
        self::assertTrue($this->client->getCheckErrorPages());
    }

    public function testSetGetUriToGet() : void
    {
        $uri = 'www.example.com';
        $this->client->setUriToGet($uri);
        self::assertEquals($uri, $this->client->getUriToGet());
    }

    public function testSetGetRequestMethodException() : void
    {
        self::expectException(InvalidArgumentException::class);
        $this->client->setRequestMethod(15);
    }

    public function testSetGetRequestMethod() : void
    {
        $requestMethod = HttpClient::REQUEST_POST;
        $this->client->setRequestMethod($requestMethod);
        self::assertEquals($requestMethod, $this->client->getRequestMethod());
    }

    /**
     * @function testCreateHeaders
     * @param string $docName
     * @param string $expectedMimeType
     * @dataProvider dataProvider
     */
    public function testCreateHeaders(string $docName, string $expectedMimeType) : void
    {
        $docString = file_get_contents($this->fixturesDir . $docName) ?: '';
        $expectedResult = ['Content-Type' => $expectedMimeType];
        $actualResult = $this->client->createHeaders($docString);
        self::assertEquals($expectedResult, $actualResult);
    }

    public function dataProvider() : array
    {
        return [
            'no charset declaration' => ['document-invalid-html4.html', 'text/html; charset=us-ascii'],
            'should be utf-8 within a meta tag' => ['document-invalid-utf8-html5.html', 'text/html; charset=UTF-8'],
            'should be utf-8 within the opening xml tag' => ['document-invalid-xml.xml', 'image/svg+xml; charset=UTF-8']
        ];
    }

    public function testCreateQueryArray() : void
    {
        $array = $this->client->createQueryArray();
        self::assertIsArray($array);
        self::assertEquals('json', $array['out']);

        $this->client->parseXml(true);
        $array = $this->client->createQueryArray();
        self::assertEquals('xml', $array['parser']);

        $this->client->loadXXE(true);
        $array = $this->client->createQueryArray();
        self::assertEquals('xmldtd', $array['parser']);

        $schema = Mockery::mock(Schema::class);
        $schema->shouldReceive('getNamespace')->withNoArgs()->andReturn('someNamespace');
        $schema->shouldReceive('getLocation')->withNoArgs()->andReturn('someLocation');
        $this->client->addSchema($schema);
        self::assertEquals(1, count($this->client->getSchemas()));

        $schema_next = Mockery::mock(Schema::class);
        $schema_next->shouldReceive('getNamespace')->withNoArgs()->andReturn('someOtherNamespace');
        $schema_next->shouldReceive('getLocation')->withNoArgs()->andReturn('someOtherLocation');
        $this->client->addSchema($schema_next);

        $array = $this->client->createQueryArray();
        self::assertEquals('someLocation someOtherLocation', $array['schemas']);

        $this->client->setCheckErrorPages(true);
        $array = $this->client->createQueryArray();
        self::assertEquals('yes', $array['checkerrorpages']);

        $uriToGet = 'http://www.example.com';
        $this->client->setUriToGet($uriToGet);
        $array = $this->client->createQueryArray();
        self::assertEquals($uriToGet, $array['doc']);
    }
}
