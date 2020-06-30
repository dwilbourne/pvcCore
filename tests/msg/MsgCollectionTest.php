<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\msg;

use Iterator;
use Mockery;
use PHPUnit\Framework\TestCase;
use pvc\msg\Msg;
use pvc\msg\MsgCollection;

class MsgCollectionTest extends TestCase
{

    protected MsgCollection $msgCollection;

    public function setUp(): void
    {
        $this->msgCollection = new MsgCollection();
    }

    public function testIterator() : void
    {
        self::assertTrue($this->msgCollection instanceof Iterator);
        self::assertEquals(0, count($this->msgCollection));
    }

    public function testAdd() : void
    {

        $msg_1 = Mockery::mock(Msg::class);
        $var_1 = 'foo';
        $text_1 = 'some message text = %s';
        $msg_1->shouldReceive('getMsgVars')->withNoArgs()->andReturn([$var_1]);
        $msg_1->shouldReceive('getMsgText')->withNoArgs()->andReturn($text_1);

        $msg_2 = Mockery::mock(Msg::class);
        $var_2 = 'bar';
        $text_2 = 'some new message text = %s';
        $msg_2->shouldReceive('getMsgVars')->withNoArgs()->andReturn([$var_2]);
        $msg_2->shouldReceive('getMsgText')->withNoArgs()->andReturn($text_2);

        /** @phpstan-ignore-next-line */
        $this->msgCollection->addMsg($msg_1);
        self::assertEquals(1, count($this->msgCollection));

        /** @phpstan-ignore-next-line */
        $this->msgCollection->addMsg($msg_2);
        self::assertEquals(2, count($this->msgCollection));

        $expectedResult = [[$var_1], [$var_2]];
        self::assertEquals($expectedResult, $this->msgCollection->getMsgVars());

        $expectedResult = $text_1 . PHP_EOL . $text_2 . PHP_EOL;
        self::assertEquals($expectedResult, $this->msgCollection->getMsgText());
    }
}
