<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\base\data_type;

/**
 * Class ValidatorInteger
 */
class ValidatorTypeInteger extends ValidatorType
{

    /**
     * ValidatorTypeInteger constructor.
     */
    public function __construct()
    {
        parent::__construct('integer');
    }

    /**
     * @function validateType
     * @param mixed $value
     * @return bool
     */
    public function validateType($value): bool
    {
        return is_integer($value);
    }
}
