<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\numeric;

use pvc\msg\Msg;
use pvc\validator\base\data_type\ValidatorTypeInteger;
use pvc\validator\base\min_max\ValidatorMinMaxInteger;
use pvc\validator\base\Validator;
use pvc\validator\base\ValidatorInterface;

/**
 * Class ValidatorIntegerNonNegative
 */
class ValidatorIntegerNonNegative extends Validator
{
    /**
     * ValidatorIntegerNonNegative constructor.
     * @param bool $notNull
     * @throws \pvc\err\throwable\exception\pvc_exceptions\InvalidTypeException
     * @throws \pvc\err\throwable\exception\pvc_exceptions\InvalidValueException
     */
    public function __construct(bool $notNull = true)
    {
        $vt = new ValidatorTypeInteger();
        parent::__construct($vt, $notNull);
        $vmm = new ValidatorMinMaxInteger(0, PHP_INT_MAX);
        $this->push($vmm);
    }
}
