<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\msg;

use pvc\formatter\msg\FrmtrMsg;
use pvc\msg\ErrorExceptionMsg;
use pvc\msg\Msg;
use PHPUnit\Framework\TestCase;

class MsgTest extends TestCase
{

    protected string $var1;
    protected string $var2;
    protected array $vars;
    protected string $msgText;
    protected Msg $msg;

    public function setUp(): void
    {
        $this->var1 = 'foo';
        $this->var2 = 'bar';
        $this->vars = [$this->var1, $this->var2];
        $this->msgText = 'this is some text = %s, %s';
        $this->msg = new Msg($this->vars, $this->msgText);
    }

    public function testAddCountMsgVar() : void
    {
        self::assertEquals(2, $this->msg->countMsgVars());
        $this->msg->addMsgVar('var3');
        self::assertEquals(3, $this->msg->countMsgVars());
    }

    public function testSetGetMsgVars() : void
    {
        $array = ['var3', 'var4'];
        $this->msg->setMsgVars($array);
        self::assertEquals($array, $this->msg->getMsgVars());
    }

    public function testSetGetMsgText() : void
    {
        $text = 'this is some text';
        $this->msg->setMsgText($text);
        self::assertEquals($text, $this->msg->getMsgText());
    }

    public function testMakeErrorExceptionMsg() : void
    {
        $msg = $this->msg->makeErrorExceptionMsg();
        self::assertTrue($msg instanceof ErrorExceptionMsg);
    }

    public function testToString() : void
    {
        $expectedResult = 'this is some text = foo, bar';
        self::assertEquals($expectedResult, (string) $this->msg);
    }
}
