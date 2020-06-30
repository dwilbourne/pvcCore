<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\base\data_type;

use Carbon\Carbon;

/**
 * Class ValidatorTypeDate
 */
class ValidatorTypeCarbonDate extends ValidatorType
{

    /**
     * ValidatorTypeCarbonDate constructor.
     */
    public function __construct()
    {
        parent::__construct('Carbon object with no hours, minutes or seconds');
    }

    /**
     * @function validateType
     * @param mixed $value
     * @return bool
     */
    public function validateType($value): bool
    {
        // internationalize this??
        $result = ($value instanceof Carbon);
        $result = $result && ($value->format('H') == 0);
        $result = $result && ($value->format('i') == 0);
        $result = $result && ($value->format('s') == 0);
        $result = $result && ($value->format('u') == 0);
        return $result;
    }
}
