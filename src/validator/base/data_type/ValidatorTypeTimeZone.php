<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\base\data_type;

use pvc\intl\TimeZone;
use pvc\validator\base\data_type\ValidatorType;
use pvc\validator\base\ValidatorInterface;

/**
 * Class ValidatorTimeZone
 */
class ValidatorTypeTimeZone extends ValidatorType implements ValidatorInterface
{

    /**
     * ValidatorTypeTimeZone constructor.
     */
    public function __construct()
    {
        parent::__construct('Timezone');
    }

    /**
     * @function validateType
     * @param mixed $value
     * @return bool
     */
    public function validateType($value): bool
    {
        return ($value instanceof TimeZone);
    }
}
