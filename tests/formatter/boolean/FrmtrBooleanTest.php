<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\formatter\boolean;

use pvc\formatter\boolean\err\AddBooleanFormatException;
use pvc\formatter\boolean\err\SetBooleanFormatException;
use pvc\formatter\boolean\FrmtrBoolean;
use PHPUnit\Framework\TestCase;

class FrmtrBooleanTest extends TestCase
{
    protected FrmtrBoolean $frmtr;

    public function setUp() : void
    {
        $this->frmtr = new FrmtrBoolean();
    }

    public function testCreateGetFormats() : void
    {
        $formats = $this->frmtr->getFormats();
        self::assertEquals(3, count($formats));
        $expectedResult = ['yes', 'true', 1];
        self::assertEquals($expectedResult, array_keys($this->frmtr->getFormats()));
    }

    public function testAddGetFormats() : void
    {
        $this->frmtr->addFormat('YES', 'NO');
        $formats = $this->frmtr->getFormats();
        self::assertEquals(4, count($formats));
        $expectedResult = ['yes', 'true', 1, 'YES'];
        self::assertEquals($expectedResult, array_keys($this->frmtr->getFormats()));
    }

    public function testAddFormatException() : void
    {
        self::expectException(AddBooleanFormatException::class);
        $this->frmtr->addFormat('Vrais', 'Vrais');
    }

    public function testSetGetFormat() : void
    {
        $format = '1';
        $this->frmtr->setFormat($format);
        self::assertEquals($format, $this->frmtr->getFormat());
    }

    public function testSetFormatException() : void
    {
        self::expectException(SetBooleanFormatException::class);
        $this->frmtr->setFormat('Vrais');
    }

    public function testFormatValue() : void
    {
        $this->frmtr->setFormat('yes');
        $expectedResult = 'no';
        self::assertEquals($expectedResult, $this->frmtr->format(false));

        $this->frmtr->setFormat('1');
        $expectedResult = '1';
        self::assertEquals($expectedResult, $this->frmtr->format(true));

        $this->frmtr->setFormat('true');
        $expectedResult = 'false';
        self::assertEquals($expectedResult, $this->frmtr->format(false));
    }
}
