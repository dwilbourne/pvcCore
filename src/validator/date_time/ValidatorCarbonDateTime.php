<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\date_time;

use Carbon\Carbon;
use pvc\err\throwable\exception\pvc_exceptions\InvalidTypeException;
use pvc\err\throwable\exception\pvc_exceptions\InvalidValueException;
use pvc\validator\base\data_type\ValidatorTypeCarbonDateTime;
use pvc\validator\base\min_max\ValidatorMinMaxCarbonDateTime;
use pvc\validator\base\Validator;
use pvc\validator\base\ValidatorInterface;

/**
 * Class ValidatorCarbonDate
 */

class ValidatorCarbonDateTime extends Validator implements ValidatorInterface
{
    public const MIN_DATE_TIME = -377705099038;
    public const MAX_DATE_TIME = 253402318799;

    /**
     * @var ValidatorMinMaxCarbonDateTime
     */
    protected ValidatorMinMaxCarbonDateTime $validator;

    /**
     * ValidatorCarbonDateTime constructor.
     * @param Carbon|null $min
     * @param Carbon|null $max
     * @param bool $required
     * @throws InvalidTypeException
     * @throws InvalidValueException
     */
    public function __construct(Carbon $min = null, Carbon $max = null, bool $required = true)
    {

        $vt = new ValidatorTypeCarbonDateTime();
        parent::__construct($vt, $required);

        $min = ($min ?: Carbon::createFromTimestamp(self::MIN_DATE_TIME));
        $max = ($max ?: Carbon::createFromTimestamp(self::MAX_DATE_TIME));

        $this->validator = new ValidatorMinMaxCarbonDateTime($min, $max);
        $this->push($this->validator);
    }

    /**
     * @function getMin
     * @return Carbon
     */
    public function getMin(): Carbon
    {
        return $this->validator->getMin();
    }

    /**
     * @function setMin
     * @param Carbon $min
     * @throws \pvc\err\throwable\exception\pvc_exceptions\InvalidTypeException
     * @throws \pvc\err\throwable\exception\pvc_exceptions\InvalidValueException
     */
    public function setMin(Carbon $min): void
    {
        $this->validator->setMin($min);
    }

    /**
     * @function getMax
     * @return Carbon
     */
    public function getMax(): Carbon
    {
        return $this->validator->getMax();
    }

    /**
     * @function setMax
     * @param Carbon $max
     * @throws InvalidTypeException
     * @throws InvalidValueException
     */
    public function setMax(Carbon $max): void
    {
        $this->validator->setMax($max);
    }
}
