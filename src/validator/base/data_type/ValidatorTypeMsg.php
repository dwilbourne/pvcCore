<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\base\data_type;

use pvc\msg\Msg;

/**
 * Class ValidatorTypeMsg
 */
class ValidatorTypeMsg extends ValidatorType
{
    /**
     * ValidatorTypeMsg constructor.
     */
    public function __construct()
    {
        parent::__construct('Msg');
    }

    /**
     * @function validateType
     * @param mixed $value
     * @return bool
     */
    public function validateType($value): bool
    {
        return ($value instanceof Msg);
    }
}
