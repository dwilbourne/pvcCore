<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\formatter\numeric;

use Mockery;
use NumberFormatter;
use pvc\formatter\numeric\FrmtrNumberFormatter;
use PHPUnit\Framework\TestCase;

class FrmtrNumberFormatterTest extends TestCase
{
    public function testSetGetFrmtr() : void
    {
        $frmtr = new NumberFormatter('en-US', NumberFormatter::TYPE_INT64);
        $mock = Mockery::mock(FrmtrNumberFormatter::class)->makePartial();
        $mock->setFormatter($frmtr);
        self::assertEquals($frmtr, $mock->getFormatter());
    }
}
