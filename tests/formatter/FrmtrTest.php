<?php

namespace tests\formatter;

use PHPUnit\Framework\TestCase;
use Mockery as m;
use pvc\formatter\Frmtr;

class FrmtrTest extends TestCase
{
    /** @phpstan-ignore-next-line */
    protected $frmtr;

    public function setUp(): void
    {
        $this->frmtr = m::mock(Frmtr::class)->makePartial();
    }

    public function testSetGetFormat() : void
    {
        $format = "foo";
        $this->frmtr->setFormat($format);
        self::assertEquals($format, $this->frmtr->getFormat());
    }
}
