<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\formatter\msg;

use pvc\formatter\msg\FrmtrMsgText;
use PHPUnit\Framework\TestCase;
use pvc\msg\Msg;

class FrmtrMsgTextTest extends TestCase
{
    protected array $vars;
    protected string $msgText;
    protected Msg $msg;
    protected FrmtrMsgText $frmtr;

    public function setUp(): void
    {
        $escapeChar = chr(27);
        $tabChar = chr(9);

        $this->vars = ['some ' . $tabChar . 'text'];
        $this->msgText = 'insert %s ' . $escapeChar . 'here';

        $this->msg = new Msg($this->vars, $this->msgText);
        $this->frmtr = new FrmtrMsgText();
    }

    public function testFormat() : void
    {
        $expectedResult = 'insert some text here';
        self::assertEquals($expectedResult, $this->frmtr->format($this->msg));
    }
}
