<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\formatter\text;

use pvc\formatter\text\FrmtrText;
use PHPUnit\Framework\TestCase;

class FrmtrTextTest extends TestCase
{
    protected FrmtrText $frmtr;

    public function setUp() : void
    {
        $this->frmtr = new FrmtrText();
    }

    public function testFormat() : void
    {
        $subject = '5';
        $expectedResult = $subject;
        self::assertEquals($expectedResult, $this->frmtr->format($subject));
    }
}
