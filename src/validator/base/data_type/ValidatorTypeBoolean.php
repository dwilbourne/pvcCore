<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\base\data_type;

/**
 * Class ValidatorTypeBoolean
 */
class ValidatorTypeBoolean extends ValidatorType
{

    /**
     * ValidatorTypeBoolean constructor.
     */
    public function __construct()
    {
        parent::__construct('boolean');
    }

    /**
     * @function validateType
     * @param mixed $value
     * @return bool
     */
    public function validateType($value): bool
    {
        return is_bool($value);
    }
}
