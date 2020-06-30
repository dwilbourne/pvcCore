<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\fraction_math;

use pvc\fraction_math\err\InvalidDenominatorException;
use pvc\fraction_math\Fraction;
use PHPUnit\Framework\TestCase;

class FractionTest extends TestCase
{
    protected Fraction $fraction;
    protected int $numerator;
    protected int $denominator;
    protected int $wholeNumber;

    public function setUp() : void
    {
        $this->numerator = 6;
        $this->denominator = 8;
        $this->wholeNumber = 1;
        $this->fraction = new Fraction($this->numerator, $this->denominator, $this->wholeNumber);
    }

    public function testSetGetNumerator() : void
    {
        $numerator = 5;
        $this->fraction->setNumerator($numerator);
        self::assertEquals($numerator, $this->fraction->getNumerator());
    }

    public function testSetGetDenominator() : void
    {
        $denominator = 5;
        $this->fraction->setDenominator($denominator);
        self::assertEquals($denominator, $this->fraction->getDenominator());
    }

    public function testSetBadDenominator() : void
    {
        self::expectException(InvalidDenominatorException::class);
        $this->fraction->setDenominator(0);
    }

    public function testAutoSimplifyFalse() : void
    {
        $f = new Fraction(3, 9, 0, false);
        self::assertEquals(3, $f->getNumerator());
        self::assertEquals(9, $f->getDenominator());
    }
}
