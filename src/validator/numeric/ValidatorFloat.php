<?php declare(strict_types = 1);

namespace pvc\validator\numeric;

use pvc\validator\base\data_type\ValidatorTypeFloat;
use pvc\validator\base\min_max\ValidatorMinMaxFloat;
use pvc\validator\base\Validator;

/**
 * Class ValidatorFloat
 */
class ValidatorFloat extends Validator
{
    /**
     * ValidatorFloat constructor.
     * @param float $min
     * @param float $max
     * @param bool $notNull
     * @throws \pvc\err\throwable\exception\pvc_exceptions\InvalidTypeException
     * @throws \pvc\err\throwable\exception\pvc_exceptions\InvalidValueException
     */
    public function __construct(float $min = PHP_FLOAT_MIN, float $max = PHP_FLOAT_MAX, bool $notNull = true)
    {
        $vt = new ValidatorTypeFloat();
        parent::__construct($vt, $notNull);
        if (($min !== PHP_FLOAT_MIN) || ($max !== PHP_FLOAT_MAX)) {
            $mm = new ValidatorMinMaxFloat($min, $max);
            $this->push($mm);
        }
    }
}
