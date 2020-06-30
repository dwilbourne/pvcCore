<?php declare(strict_types = 1);

namespace pvc\fraction_math;

use pvc\fraction_math\err\InvalidDenominatorException;

/**
 * Fraction allows you to represent fractional numbers with perfect precision.
 *
 * Class Fraction
 */
class Fraction
{

    /**
     * @var int
     */
    protected int $numerator;

    /**
     * @var int
     */
    protected int $denominator;

    /**
     * Fraction constructor.
     * @param int $numerator
     * @param int $denominator
     * @param int $wholeNum
     * @param bool $autoSimplify
     * @throws InvalidDenominatorException
     */
    public function __construct(int $numerator, int $denominator, int $wholeNum = 0, bool $autoSimplify = true)
    {
        $this->setNumerator($numerator);
        $this->setDenominator($denominator);
        $this->numerator += ($wholeNum * $this->getDenominator());
        if ($autoSimplify) {
            FractionMath::simplify($this);
        }
    }

    /**
     * @function getDenominator
     * @return int
     */
    public function getDenominator(): int
    {
        return $this->denominator;
    }

    /**
     * @function setDenominator
     * @param int $denominator
     * @throws InvalidDenominatorException
     */
    public function setDenominator(int $denominator): void
    {
        if ($denominator == 0) {
            throw new InvalidDenominatorException();
        }
        $this->denominator = $denominator;
    }

    /**
     * @function getNumerator
     * @return int
     */
    public function getNumerator(): int
    {
        return $this->numerator;
    }

    /**
     * @function setNumerator
     * @param int $numerator
     */
    public function setNumerator(int $numerator): void
    {
        $this->numerator = $numerator;
    }
}
