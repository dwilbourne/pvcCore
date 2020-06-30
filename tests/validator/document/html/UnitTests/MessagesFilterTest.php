<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\document\html\UnitTests;

use Mockery;
use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentException;
use pvc\validator\document\html\Message;
use pvc\validator\document\html\Messages;
use pvc\validator\document\html\MessagesFilter;
use PHPUnit\Framework\TestCase;

class MessagesFilterTest extends TestCase
{
    /** @phpstan-ignore-next-line */
    protected $msg1;

    /** @phpstan-ignore-next-line */
    protected $msg2;

    /** @phpstan-ignore-next-line */
    protected $msg3;

    protected Messages $messages;

    public function setUp() : void
    {
        $this->msg1 = Mockery::mock(Message::class);
        $this->msg1->expects('getReportingLevel')->withNoArgs()->andReturns(Message::MESSAGE_TYPE_INFO);
        $this->msg1->expects('getMessage')->withNoArgs()->andReturns('message 1');

        $this->msg2 = Mockery::mock(Message::class);
        $this->msg2->expects('getReportingLevel')->withNoArgs()->andReturns(Message::MESSAGE_TYPE_WARNING);
        $this->msg2->expects('getMessage')->withNoArgs()->andReturns('message 2');

        $this->msg3 = Mockery::mock(Message::class);
        $this->msg3->expects('getReportingLevel')->withNoArgs()->andReturns(Message::MESSAGE_TYPE_ERROR);
        $this->msg3->expects('getMessage')->withNoArgs()->andReturns('message 3');

        $this->messages = new Messages();
        $this->messages->addMsg($this->msg1);
        $this->messages->addMsg($this->msg2);
        // add the third message as necessary below
        // $messagesFilter->addMsg($this->msg3);
    }

    public function testSetGetReportingLevel() : void
    {
        $messagesFilter = new MessagesFilter($this->messages);
        self::assertEquals(Message::MESSAGE_TYPE_ALL, $messagesFilter->getReportingLevel());
        $flags = Message::MESSAGE_TYPE_ERROR | Message::MESSAGE_TYPE_WARNING;
        $messagesFilter->setReportingLevel($flags);
        self::assertEquals($flags, $messagesFilter->getReportingLevel());
    }

    public function testSetReportingLevelException() : void
    {
        $messagesFilter = new MessagesFilter($this->messages);
        self::expectException(InvalidArgumentException::class);
        $messagesFilter->setReportingLevel(100);
    }

    public function testAcceptAndGetIndex() : void
    {
        $this->messages->addMsg($this->msg3);
        $messagesFilter = new MessagesFilter($this->messages);
        $flags = Message::MESSAGE_TYPE_ERROR | Message::MESSAGE_TYPE_WARNING;
        $this->msg1->expects('shouldBeReported')->with($flags)->andReturns(false);
        $this->msg2->expects('shouldBeReported')->with($flags)->andReturns(true);
        $this->msg3->expects('shouldBeReported')->with($flags)->andReturns(true);
        $messagesFilter->setReportingLevel($flags);
        self::assertEquals(2, count($messagesFilter));

        $m = $messagesFilter->getMessage(0) ?: new Message();
        self::assertEquals('message 2', $m->getMessage());

        $m = $messagesFilter->getMessage(1) ?: new Message();
        self::assertEquals('message 3', $m->getMessage());

        $flags = Message::MESSAGE_TYPE_ALL;
        $messagesFilter->setReportingLevel($flags);
        $this->msg1->expects('shouldBeReported')->with($flags)->andReturns(true);
        $this->msg2->expects('shouldBeReported')->with($flags)->andReturns(true);
        $this->msg3->expects('shouldBeReported')->with($flags)->andReturns(true);

        $m = $messagesFilter->getMessage(0) ?: new Message();
        self::assertEquals('message 1', $m->getMessage());

        self::assertNull($messagesFilter->getMessage(5));
    }


    public function testSetGetFailureThreshold() : void
    {
        $messagesFilter = new MessagesFilter($this->messages);
        $failureThreshold = Message::MESSAGE_TYPE_WARNING;
        $messagesFilter->setFailureThreshold($failureThreshold);
        self::assertEquals($failureThreshold, $messagesFilter->getFailureThreshold());
    }

    public function testSetFailureThresholdException() : void
    {
        $messagesFilter = new MessagesFilter($this->messages);
        self::expectException(InvalidArgumentException::class);
        $failureThreshold = 999;
        $messagesFilter->setFailureThreshold($failureThreshold);
    }

    public function testExceedsFailureThresholdTrue() : void
    {
        $this->messages->addMsg($this->msg3);
        $messagesFilter = new MessagesFilter($this->messages);
        $failureThreshold = Message::MESSAGE_TYPE_WARNING;
        $messagesFilter->setFailureThreshold($failureThreshold);
        self::assertTrue($messagesFilter->exceedFailureThreshold());
    }

    public function testExceedsFailureThresholdFalse() : void
    {
        $messagesFilter = new MessagesFilter($this->messages);
        $failureThreshold = Message::MESSAGE_TYPE_ERROR;
        $messagesFilter->setFailureThreshold($failureThreshold);
        self::assertFalse($messagesFilter->exceedFailureThreshold());
    }
}
