<?php declare(strict_types = 1);

namespace pvc\validator\numeric;

use pvc\err\throwable\exception\pvc_exceptions\InvalidTypeException;
use pvc\err\throwable\exception\pvc_exceptions\InvalidValueException;
use pvc\validator\base\data_type\ValidatorTypeInteger;
use pvc\validator\base\min_max\ValidatorMinMaxInteger;
use pvc\validator\base\Validator;

/**
 * Class ValidatorInteger
 */
class ValidatorInteger extends Validator
{
    /**
     * ValidatorInteger constructor.
     * @param int $min
     * @param int $max
     * @param bool $notNull
     * @throws InvalidTypeException
     * @throws InvalidValueException
     */
    public function __construct(int $min = PHP_INT_MIN, int $max = PHP_INT_MAX, bool $notNull = true)
    {
        $vt = new ValidatorTypeInteger();
        parent::__construct($vt, $notNull);
        if (($min !== PHP_INT_MIN) || ($max !== PHP_INT_MAX)) {
            $vmm = new ValidatorMinMaxInteger($min, $max);
            $this->push($vmm);
        }
    }
}
