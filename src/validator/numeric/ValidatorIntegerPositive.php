<?php declare(strict_types = 1);

namespace pvc\validator\numeric;

use pvc\validator\base\data_type\ValidatorTypeInteger;
use pvc\validator\base\min_max\ValidatorMinMaxInteger;
use pvc\validator\base\Validator;

/**
 * Class ValidatorIntegerPositive
 */
class ValidatorIntegerPositive extends Validator
{
    /**
     * ValidatorIntegerPositive constructor.
     * @param bool $notNull
     * @throws \pvc\err\throwable\exception\pvc_exceptions\InvalidTypeException
     * @throws \pvc\err\throwable\exception\pvc_exceptions\InvalidValueException
     */
    public function __construct(bool $notNull = true)
    {
        $vt = new ValidatorTypeInteger();
        parent::__construct($vt, $notNull);
        $vmm = new ValidatorMinMaxInteger(1, PHP_INT_MAX);
        $this->push($vmm);
    }
}
