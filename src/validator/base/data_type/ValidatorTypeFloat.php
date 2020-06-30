<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\base\data_type;

/**
 * Class ValidatorFloat
 */
class ValidatorTypeFloat extends ValidatorType
{

    /**
     * ValidatorTypeFloat constructor.
     */
    public function __construct()
    {
        parent::__construct('float');
    }

    /**
     * @function validateType
     * @param mixed $value
     * @return bool
     */
    public function validateType($value): bool
    {
        return is_float($value);
    }
}
