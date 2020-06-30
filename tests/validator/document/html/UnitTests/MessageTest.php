<?php

namespace tests\validator\document\html\UnitTests;

use PHPUnit\Framework\TestCase;
use pvc\validator\document\html\Message;

class MessageTest extends TestCase
{
    protected array $data;
    protected Message $message;
    
    public function setUp() : void
    {
        $this->data = [
            'type' => 'error',
            'subtype' => 'fatal',
            'message' => 'Foobar',
            'extract' => '<strong>Foo</strong>',
            'offset' => 20,
            'url' => 'www.example.com',
            'firstLine' => 1,
            'lastLine' => 2,
            'firstColumn' => 3,
            'lastColumn' => 4,
            'hiliteStart' => 5,
            'hiliteLength' => 6,
        ];
        $this->message = new Message($this->data);
    }
    
    public function testCanPopulate() : void
    {
        static::assertSame($this->data['type'], $this->message->getType());
        static::assertSame($this->data['subtype'], $this->message->getSubType());
        static::assertSame($this->data['firstLine'], $this->message->getFirstLine());
        static::assertSame($this->data['lastLine'], $this->message->getLastLine());
        static::assertSame($this->data['firstColumn'], $this->message->getFirstColumn());
        static::assertSame($this->data['lastColumn'], $this->message->getLastColumn());
        static::assertSame($this->data['hiliteStart'], $this->message->getHighlightStart());
        static::assertSame($this->data['hiliteLength'], $this->message->getHighlightLength());
        static::assertSame($this->data['message'], $this->message->getMessage());
        static::assertSame($this->data['extract'], $this->message->getExtract());
        static::assertSame($this->data['offset'], $this->message->getOffset());
        static::assertSame($this->data['url'], $this->message->getUrl());
    }

    /**
     * Ensure first line gets populated if not present in data set
     *
     * @covers \HtmlValidator\Message::__construct
     * @covers \HtmlValidator\Message::getFirstLine
     */
    public function testPopulatesFirstLineDataIfNotPresent() : void
    {
        $data = [
            'type' => 'error',
            'lastLine' => 2,
            'firstColumn' => 3,
            'lastColumn' => 4,
            'hiliteStart' => 5,
            'hiliteLength' => 6,
            'message' => 'Foobar',
            'extract' => '<strong>Foo</strong>',
        ];

        $message = new Message($data);
        static::assertSame($data['lastLine'], $message->getFirstLine());
    }

    public function testSetGetReportingLevelAndText() : void
    {
        $flags = Message::MESSAGE_TYPE_ERROR | Message::MESSAGE_TYPE_ERROR_FATAL;

        self::assertEquals(Message::MESSAGE_TYPE_ERROR_FATAL, $this->message->getReportingLevel());
        self::assertEquals('ERROR (FATAL)', $this->message->getReportingLevelText());
        self::assertTrue($this->message->shouldBeReported($flags));

        $this->data['subtype'] = '';
        $message = new Message($this->data);
        self::assertEquals(Message::MESSAGE_TYPE_ERROR, $message->getReportingLevel());
        self::assertEquals('ERROR', $message->getReportingLevelText());
        self::assertTrue($message->shouldBeReported($flags));

        $this->data['type'] = 'info';
        $this->data['subtype'] = '';
        $message = new Message($this->data);
        self::assertEquals(Message::MESSAGE_TYPE_INFO, $message->getReportingLevel());
        self::assertEquals('INFO', $message->getReportingLevelText());
        self::assertFalse($message->shouldBeReported($flags));

        $this->data['type'] = 'info';
        $this->data['subtype'] = 'warning';
        $message = new Message($this->data);
        self::assertEquals(Message::MESSAGE_TYPE_WARNING, $message->getReportingLevel());
        self::assertEquals('WARNING', $message->getReportingLevelText());
        self::assertFalse($message->shouldBeReported($flags));

        $this->data['type'] = 'non-document-error';
        $this->data['subtype'] = '';
        $message = new Message($this->data);
        self::assertEquals(Message::MESSAGE_TYPE_ERROR_FATAL, $message->getReportingLevel());
        self::assertEquals('ERROR (FATAL)', $message->getReportingLevelText());
        self::assertTrue($message->shouldBeReported($flags));
    }

    public function testGetMessageText() : void
    {
        $expectedResult = 'Foobar';
        self::assertEquals($expectedResult, $this->message->getMsgText());
    }

    public function testGetMsgVars() : void
    {
        $expectedResult = [];
        foreach ($this->data as $index => $value) {
            if ($index != 'message') {
                $expectedResult[] = $value;
            }
        }
        self::assertEquals($expectedResult, $this->message->getMsgVars());
    }
}
