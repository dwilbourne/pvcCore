<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\formatter\text;

use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentException;
use pvc\formatter\text\err\FrmtrTextCensorException;
use pvc\formatter\text\FrmtrTextCensor;
use PHPUnit\Framework\TestCase;

class FrmtrTextCensorTest extends TestCase
{
    protected FrmtrTextCensor $frmtr;

    public function setUp(): void
    {
        $this->frmtr = new FrmtrTextCensor();
    }

    public function testSetGetFirstCharsDisplayed() : void
    {
        $input = 5;
        $this->frmtr->setFirstCharsDisplayed($input);
        self::assertEquals($input, $this->frmtr->getFirstCharsDisplayed());

        $input = -3;
        self::expectException(FrmtrTextCensorException::class);
        $this->frmtr->setFirstCharsDisplayed($input);
    }

    public function testSetGetLastCharsDisplayed() : void
    {
        $input = 5;
        $this->frmtr->setLastCharsDisplayed($input);
        self::assertEquals($input, $this->frmtr->getLastCharsDisplayed());

        $input = -3;
        self::expectException(FrmtrTextCensorException::class);
        $this->frmtr->setLastCharsDisplayed($input);
    }

    public function testSetGetReplacementChars() : void
    {
        $chars = 'xyz123';
        $this->frmtr->setReplacementChars($chars);
        self::assertEquals($chars, $this->frmtr->getReplacementChars());
    }

    public function testFormat() : void
    {
        $this->frmtr->setReplacementChars('x');
        $subject = '123456789';

        $expectedResult = 'xxxxxxxxx';
        self::assertEquals($expectedResult, $this->frmtr->format($subject));
    }

    public function testFormatNoPadding() : void
    {
        $this->frmtr->setReplacementChars('x');
        $subject = '123456789';
        $this->frmtr->setFirstCharsDisplayed(9);

        $expectedResult = $subject;
        self::assertEquals($expectedResult, $this->frmtr->format($subject));
    }

    public function testFormatException() : void
    {
        $subject = 34;
        self::expectException(InvalidArgumentException::class);
        $this->frmtr->format(($subject));
    }
}
