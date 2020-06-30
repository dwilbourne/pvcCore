<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\fraction_math;

use pvc\fraction_math\Fraction;
use PHPUnit\Framework\TestCase;
use pvc\fraction_math\FractionMath;

class FractionMathTest extends TestCase
{
    public function testAdd() : void
    {
        $fractionA = new Fraction(1, 2);
        $fractionB = new Fraction(1, 3);
        $expectedResult = new Fraction(5, 6);
        self::assertTrue(FractionMath::equals($expectedResult, FractionMath::add($fractionA, $fractionB)));
    }

    public function testSubtract() : void
    {
        $fractionA = new Fraction(1, 2);
        $fractionB = new Fraction(1, 3);
        $expectedResult = new Fraction(1, 6);
        self::assertTrue(FractionMath::equals($expectedResult, FractionMath::subtract($fractionA, $fractionB)));
    }

    public function testMultiply() : void
    {
        $fractionA = new Fraction(1, 2);
        $fractionB = new Fraction(1, 3);
        $expectedResult = new Fraction(1, 6);
        self::assertTrue(FractionMath::equals($expectedResult, FractionMath::multiply($fractionA, $fractionB)));
    }

    public function testDivide() : void
    {
        $fractionA = new Fraction(1, 2);
        $fractionB = new Fraction(1, 3);
        $expectedResult = new Fraction(3, 2);
        self::assertTrue(FractionMath::equals($expectedResult, FractionMath::divide($fractionA, $fractionB)));
    }

    public function testSimplify() : void
    {
        $fractionA = new Fraction(9, 18);
        $expectedResult = new Fraction(1, 2);
        self::assertTrue(FractionMath::equals($expectedResult, $fractionA));
    }
}
