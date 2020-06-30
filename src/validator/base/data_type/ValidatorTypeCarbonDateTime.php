<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\base\data_type;

use Carbon\Carbon;

/**
 * Class ValidatorTypeDateTime
 */
class ValidatorTypeCarbonDateTime extends ValidatorType
{

    /**
     * ValidatorTypeCarbonDateTime constructor.
     */
    public function __construct()
    {
        parent::__construct('Carbon object');
    }

    /**
     * @function validateType
     * @param mixed $value
     * @return bool
     */
    public function validateType($value): bool
    {
        return ($value instanceof Carbon);
    }
}
