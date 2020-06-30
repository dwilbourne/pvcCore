<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\date_time;

use pvc\err\throwable\exception\pvc_exceptions\InvalidTypeException;
use pvc\err\throwable\exception\pvc_exceptions\InvalidValueException;
use pvc\intl\err\UtcOffsetException;
use pvc\msg\Msg;
use pvc\time\Time;
use pvc\validator\base\data_type\ValidatorTypeTime;
use pvc\validator\base\min_max\ValidatorMinMaxTime;
use pvc\validator\base\Validator;
use pvc\validator\base\ValidatorInterface;

/**
 * Class ValidatorTime
 */
class ValidatorTime extends Validator implements ValidatorInterface
{
    /**
     * @var Time
     */
    protected Time $min;

    /**
     * @var Time
     */
    protected Time $max;

    /**
     * @var ValidatorMinMaxTime
     */
    protected ValidatorMinMaxTime $validatorTime;

    /**
     * ValidatorTime constructor.
     * @param Time|null $min
     * @param Time|null $max
     * @param bool $required
     * @throws InvalidTypeException
     * @throws InvalidValueException
     * @throws UtcOffsetException
     */
    public function __construct(Time $min = null, Time $max = null, bool $required = true)
    {
        $vt = new ValidatorTypeTime();
        parent::__construct($vt, $required);

        $min = ($min ?: new Time(Time::MIN_TIME));
        $max = ($max ?: new Time(Time::MAX_TIME));

        $this->validatorTime = new ValidatorMinMaxTime($min, $max);
        $this->push($this->validatorTime);
    }

    /**
     * @function getMin
     * @return Time
     */
    public function getMin(): Time
    {
        return $this->validatorTime->getMin();
    }

    /**
     * @function setMin
     * @param Time $min
     * @throws InvalidTypeException
     * @throws InvalidValueException
     */
    public function setMin(Time $min): void
    {
        $this->validatorTime->setMin($min);
    }

    /**
     * @function getMax
     * @return Time
     */
    public function getMax(): Time
    {
        return $this->validatorTime->getMax();
    }

    /**
     * @function setMax
     * @param Time $max
     * @throws InvalidTypeException
     * @throws InvalidValueException
     */
    public function setMax(Time $max): void
    {
        $this->validatorTime->setMax($max);
    }
}
