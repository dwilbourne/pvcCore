<?php declare(strict_types = 1);

namespace pvc\validator\base\min_max;

use pvc\formatter\numeric\FrmtrInteger;
use pvc\validator\base\data_type\ValidatorTypeInteger;

/**
 * Class ValidatorMinMaxInteger
 */
class ValidatorMinMaxInteger extends ValidatorMinMax
{
    /**
     * @var int
     */
    protected int $min;

    /**
     * @var int
     */
    protected int $max;

    /**
     * @function setMin
     * @param int $min
     * @throws \pvc\err\throwable\exception\pvc_exceptions\InvalidTypeException
     * @throws \pvc\err\throwable\exception\pvc_exceptions\InvalidValueException
     */
    public function setMin($min) : void
    {
        $this->validateMin($min);
        $this->min = $min;
    }

    /**
     * @function getMin
     * @return int
     */
    public function getMin() : int
    {
        return $this->min ?? PHP_INT_MIN;
    }

    /**
     * @function setMax
     * @param int $max
     * @throws \pvc\err\throwable\exception\pvc_exceptions\InvalidTypeException
     * @throws \pvc\err\throwable\exception\pvc_exceptions\InvalidValueException
     */
    public function setMax($max) : void
    {
        $this->validateMax($max);
        $this->max = $max;
    }

    /**
     * @function getMax
     * @return int
     */
    public function getMax() : int
    {
        return $this->max ?? PHP_INT_MAX;
    }

    /**
     * ValidatorMinMaxInteger constructor.
     * @param int $min
     * @param int $max
     * @throws \pvc\err\throwable\exception\pvc_exceptions\InvalidTypeException
     * @throws \pvc\err\throwable\exception\pvc_exceptions\InvalidValueException
     */
    public function __construct(int $min = PHP_INT_MIN, int $max = PHP_INT_MAX)
    {
        $validator = new ValidatorTypeInteger();
        $frmtr = new FrmtrInteger();
        parent::__construct($validator, $frmtr);
        $this->setMin($min);
        $this->setMax($max);
    }

    /**
     * @function compareValues
     * @param int $a
     * @param int $b
     * @return int
     */
    public function compareValues($a, $b): int
    {
        return $a <=> $b;
    }
}
