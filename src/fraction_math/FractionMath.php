<?php declare(strict_types = 1);

namespace pvc\fraction_math;

/**
 * Library for arithmetic operations on Fraction objects
 *
 * Class FractionMath
 */
class FractionMath
{

    /**
     * @function subtract
     * @param Fraction $a
     * @param Fraction $b
     * @return Fraction
     * @throws err\InvalidDenominatorException
     */
    public static function subtract(Fraction $a, Fraction $b): Fraction
    {
        $b->setNumerator(-1 * $b->getNumerator());
        return self::add($a, $b);
    }

    /**
     * @function add
     * @param Fraction $a
     * @param Fraction $b
     * @return Fraction
     * @throws err\InvalidDenominatorException
     */
    public static function add(Fraction $a, Fraction $b): Fraction
    {
        $numeratorA = $a->getNumerator() * $b->getDenominator();
        $numeratorB = $b->getNumerator() * $a->getDenominator();
        $denominator = $a->getDenominator() * $b->getDenominator();
        return new Fraction($numeratorA + $numeratorB, $denominator);
    }

    /**
     * @function multiply
     * @param Fraction $a
     * @param Fraction $b
     * @return Fraction
     * @throws err\InvalidDenominatorException
     */
    public static function multiply(Fraction $a, Fraction $b): Fraction
    {
        $numerator = $a->getNumerator() * $b->getNumerator();
        $denominator = $a->getDenominator() * $b->getDenominator();
        return new Fraction($numerator, $denominator);
    }

    /**
     * @function divide
     * @param Fraction $a
     * @param Fraction $b
     * @return Fraction
     * @throws err\InvalidDenominatorException
     */
    public static function divide(Fraction $a, Fraction $b): Fraction
    {
        $numerator = $a->getNumerator() * $b->getDenominator();
        $denominator = $a->getDenominator() * $b->getNumerator();
        return new Fraction($numerator, $denominator);
    }

    /**
     * @function simplify
     * @param Fraction $f
     * @throws err\InvalidDenominatorException
     */
    public static function simplify(Fraction $f): void
    {
        $m = min(abs($f->getNumerator()), abs($f->getDenominator()));
        for ($i = 2; $i <= $m; $i++) {
            if (($f->getNumerator() % $i == 0) && ($f->getDenominator() % $i == 0)) {
                $f->setNumerator(intdiv($f->getNumerator(), $i));
                $f->setDenominator(intdiv($f->getDenominator(), $i));
                self::simplify($f);
            }
        }
    }

    /**
     * @function equals
     * @param Fraction $a
     * @param Fraction $b
     * @return bool
     */
    public static function equals(Fraction $a, Fraction $b)
    {
        return ($a->getNumerator() == $b->getNumerator() && $a->getDenominator() == $b->getDenominator());
    }
}
