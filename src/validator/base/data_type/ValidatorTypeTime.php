<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\base\data_type;

use pvc\time\Time;

/**
 * Class ValidatorTypeTime
 */
class ValidatorTypeTime extends ValidatorType
{

    /**
     * ValidatorTypeTime constructor.
     */
    public function __construct()
    {
        parent::__construct('Pvc Time object');
    }

    /**
     * @function validateType
     * @param mixed $value
     * @return bool
     */
    public function validateType($value): bool
    {
        return ($value instanceof Time);
    }
}
