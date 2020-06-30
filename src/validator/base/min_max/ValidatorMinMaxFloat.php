<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\base\min_max;

use pvc\formatter\numeric\FrmtrFloat;
use pvc\validator\base\data_type\ValidatorTypeFloat;

/**
 * Class MinMaxFloat
 */
class ValidatorMinMaxFloat extends ValidatorMinMax
{
    /**
     * @var float
     */
    protected float $min;

    /**
     * @var float
     */
    protected float $max;

    /**
     * @function setMin
     * @param float $min
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
     * @return float
     */
    public function getMin() :float
    {
        return $this->min ?? PHP_FLOAT_MIN;
    }

    /**
     * @function setMax
     * @param float $max
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
     * @return float
     */
    public function getMax() : float
    {
        return $this->max ?? PHP_FLOAT_MAX;
    }

    /**
     * ValidatorMinMaxFloat constructor.
     * @param float $min
     * @param float $max
     * @throws \pvc\err\throwable\exception\pvc_exceptions\InvalidTypeException
     * @throws \pvc\err\throwable\exception\pvc_exceptions\InvalidValueException
     */
    public function __construct(float $min = PHP_FLOAT_MIN, float $max = PHP_FLOAT_MAX)
    {
        $validator = new ValidatorTypeFloat();
        $frmtr = new FrmtrFloat();
        parent::__construct($validator, $frmtr);
        $this->setMin($min);
        $this->setMax($max);
    }

    /**
     * @function compareValues
     * @param float $a
     * @param float $b
     * @return int
     */
    public function compareValues($a, $b): int
    {
        return $a <=> $b;
    }
}
