<?php declare(strict_types = 1);

namespace pvc\validator\base\min_max;

use pvc\formatter\date_time\FrmtrTimeShort;
use pvc\intl\Locale;
use pvc\intl\UtcOffset;
use pvc\time\Time;
use pvc\validator\base\data_type\ValidatorTypeTime;

/**
 * Class ValidatorMinMaxTime
 */
class ValidatorMinMaxTime extends ValidatorMinMax
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
     * @function setMin
     * @param Time $min
     * @throws \pvc\err\throwable\exception\pvc_exceptions\InvalidTypeException
     * @throws \pvc\err\throwable\exception\pvc_exceptions\InvalidValueException
     */
    public function setMin($min) : void
    {
        $this->validateMin($min);
        $this->min = $min;
    }

    /**
     * @function getMin
     * @return Time
     */
    public function getMin() : Time
    {
        return $this->min ?? new Time();
    }

    /**
     * @function setMax
     * @param Time $max
     * @throws \pvc\err\throwable\exception\pvc_exceptions\InvalidTypeException
     * @throws \pvc\err\throwable\exception\pvc_exceptions\InvalidValueException
     */
    public function setMax($max) : void
    {
        $this->validateMax($max);
        $this->max = $max;
    }

    /**
     * @function getMax
     * @return Time
     */
    public function getMax() : Time
    {
        return $this->max ?? new Time(Time::MAX_TIME);
    }


    /**
     * ValidatorMinMaxTime constructor.
     * @param Time $min
     * @param Time $max
     * @throws \pvc\err\throwable\exception\pvc_exceptions\InvalidTypeException
     * @throws \pvc\err\throwable\exception\pvc_exceptions\InvalidValueException
     * @throws \pvc\intl\err\UtcOffsetException
     */
    public function __construct(Time $min = null, Time $max = null)
    {

        $validatorType = new ValidatorTypeTime();
        $locale = new Locale();
        $utcOffset = new UtcOffset();
        $utcOffset->setUtcOffsetSeconds(0);
        $frmtr = new FrmtrTimeShort($locale, $utcOffset);
        parent::__construct($validatorType, $frmtr);

        $min = ($min ?: new Time());
        $max = ($max ?: new Time(Time::MAX_TIME));
        $this->setMin($min);
        $this->setMax($max);
    }

    /**
     * @function compareValues
     * @param Time $a
     * @param Time $b
     * @return int
     */
    public function compareValues($a, $b): int
    {
        return ($a->getTimestamp() <=> $b->getTimestamp());
    }
}
