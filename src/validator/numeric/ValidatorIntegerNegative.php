<?php declare(strict_types = 1);

namespace pvc\validator\numeric;

use pvc\validator\base\data_type\ValidatorTypeInteger;
use pvc\validator\base\min_max\ValidatorMinMaxInteger;
use pvc\validator\base\Validator;

/**
 * Class ValidatorIntegerNegative
 */
class ValidatorIntegerNegative extends Validator
{
    /**
     * ValidatorIntegerNegative constructor.
     * @param bool $notNull
     * @throws \pvc\err\throwable\exception\pvc_exceptions\InvalidTypeException
     * @throws \pvc\err\throwable\exception\pvc_exceptions\InvalidValueException
     */
    public function __construct(bool $notNull = true)
    {
        $vt = new ValidatorTypeInteger();
        parent::__construct($vt, $notNull);
        $vmm = new ValidatorMinMaxInteger(PHP_INT_MIN, -1);
        $this->push($vmm);
    }
}
