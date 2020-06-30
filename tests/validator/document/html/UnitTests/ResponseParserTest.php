<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\document\html\UnitTests;

use GuzzleHttp\Psr7\Response;
use Mockery;
use pvc\validator\document\html\err\ResponseContentMsg;
use pvc\validator\document\html\Message;
use pvc\validator\document\html\Messages;
use pvc\validator\document\html\MessagesFilter;
use pvc\validator\document\html\ResponseParser;
use PHPUnit\Framework\TestCase;

class ResponseParserTest extends TestCase
{
    public function testSetGetMessages() : void
    {
        $messages = Mockery::mock(Messages::class);
        $parser = new ResponseParser($messages);
        self::assertEquals($messages, $parser->getMessages());
    }

    public function testWillFailOnInvalidJsonResponse() : void
    {
        $messages = Mockery::mock(Messages::class);
        $parser = new ResponseParser($messages);

        $invalidJsonData = '{"incompl';
        self::assertFalse($parser->parse($invalidJsonData));
        self::assertTrue($parser->getErrmsg() instanceof ResponseContentMsg);
    }

    /**
     * @function testParse
     * @return ResponseParser
     */
    /** @phpstan-ignore-next-line */
    public function testParse()
    {
        $jsonData = $this->getTestData();
        $messages = new Messages();
        $parser = new ResponseParser($messages);
        self::assertTrue($parser->parse($jsonData));
        return $parser;
    }

    /**
     * @function testMessagePopulationAndFiltering
     * @param ResponseParser $parser
     * @depends testParse
     */
    public function testMessagePopulationAndFiltering(ResponseParser $parser) : void
    {
        $messages = $parser->getParsedValue();
        $messagesFilter = new MessagesFilter($messages);
        self::assertEquals(7, count($messagesFilter));
        $messagesFilter->setReportingLevel(Message::MESSAGE_TYPE_ERROR_FATAL);
        self::assertEquals(2, count($messagesFilter));
        $messagesFilter->setReportingLevel(Message::MESSAGE_TYPE_ERROR);
        self::assertEquals(2, count($messagesFilter));
        $messagesFilter->setReportingLevel(Message::MESSAGE_TYPE_WARNING | Message::MESSAGE_TYPE_INFO);
        self::assertEquals(3, count($messagesFilter));
    }

    public function getTestData() : string
    {
        $data = [
            'language' => 'en',
            'uri' => 'www.example.com',
            'messages' => [
                [
                    'type' => 'error',
                    'subtype' => 'fatal',
                    'firstLine' => 1,
                    'lastLine' => 2,
                    'firstColumn' => 3,
                    'lastColumn' => 4,
                    'hiliteStart' => 5,
                    'hiliteLength' => 6,
                    'message' => 'Foobar',
                    'extract' => '<strong>Foo</strong>',
                ],
                [
                    'type' => 'error',
                    'subtype' => '',
                    'firstLine' => 9,
                    'lastLine' => 8,
                    'firstColumn' => 7,
                    'lastColumn' => 6,
                    'hiliteStart' => 5,
                    'hiliteLength' => 4,
                    'message' => 'Pimp Pelican',
                    'extract' => '<em>Pelican</em>',
                ],
                [
                    'type' => 'info',
                    'subtype' => '',
                    'firstLine' => 1,
                    'lastLine' => 2,
                    'firstColumn' => 3,
                    'lastColumn' => 4,
                    'hiliteStart' => 5,
                    'hiliteLength' => 6,
                    'message' => 'Foobar',
                    'extract' => '<strong>Foo</strong>',
                ],
                [
                    'type' => 'info',
                    'subtype' => 'warning',
                    'firstLine' => 9,
                    'lastLine' => 8,
                    'firstColumn' => 7,
                    'lastColumn' => 6,
                    'hiliteStart' => 5,
                    'hiliteLength' => 4,
                    'message' => 'Pimp Pelican',
                    'extract' => '<em>Pelican</em>',
                ],
                [
                    'type' => 'non-document-error',
                    'subtype' => 'io',
                    'firstLine' => 1,
                    'lastLine' => 2,
                    'firstColumn' => 3,
                    'lastColumn' => 4,
                    'hiliteStart' => 5,
                    'hiliteLength' => 6,
                    'message' => 'Foobar message',
                    'extract' => '<strong>Foo</strong>',
                ],
                [
                    'type' => 'info',
                    'subtype' => 'warning',
                    'firstLine' => 9,
                    'lastLine' => 8,
                    'firstColumn' => 7,
                    'lastColumn' => 6,
                    'hiliteStart' => 5,
                    'hiliteLength' => 4,
                    'message' => 'Pimp Pelican warning',
                    'extract' => '<em>Pelican</em>',
                ],
                [
                    'type' => 'error',
                    'subtype' => '',
                    'firstLine' => 9,
                    'lastLine' => 8,
                    'firstColumn' => 7,
                    'lastColumn' => 6,
                    'hiliteStart' => 5,
                    'hiliteLength' => 4,
                    'message' => 'Pimp Pelican error',
                    'extract' => '<em>Pelican</em>',
                ],
            ],
        ];
        return json_encode($data) ?: '';
    }

    /**
     * Get a guzzle response mock
     *
     * @param bool $expectSuccess Whether to prepare the mock with the default expectations
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
