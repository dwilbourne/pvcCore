<?php declare(strict_types = 1);

namespace pvc\validator\base\min_max;

use Carbon\Carbon;
use pvc\formatter\date_time\FrmtrDateShort;
use pvc\intl\Locale;
use pvc\intl\TimeZone;
use pvc\time\Time;
use pvc\validator\base\data_type\ValidatorTypeCarbonDate;

/**
 * Class ValidatorMinMaxCarbonDate
 */
class ValidatorMinMaxCarbonDate extends ValidatorMinMax
{
    /**
     * @var Carbon
     */
    protected Carbon $min;

    /**
     * @var Carbon
     */
    protected Carbon $max;

    /**
     * ValidatorMinMaxCarbonDate constructor.
     * @param Carbon|null $min
     * @param Carbon|null $max
     * @throws \pvc\err\throwable\exception\pvc_exceptions\InvalidTypeException
     * @throws \pvc\err\throwable\exception\pvc_exceptions\InvalidValueException
     */
    public function __construct(Carbon $min = null, Carbon $max = null)
    {
        $vt = new ValidatorTypeCarbonDate();
        $frmtr = new FrmtrDateShort();
        parent::__construct($vt, $frmtr);

        $min = ($min ?: new Carbon('-9999-01-01 00:00:00'));
        $max = ($max ?: new Carbon('9999-12-31 23:59:59'));
        $this->setMin($min);
        $this->setMax($max);
    }

    /**
     * @function setMin
     * @param Carbon $min
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
     * @return Carbon
     */
    public function getMin() : Carbon
    {
        return $this->min ?? new Carbon('-9999-01-01 00:00:00');
    }

    /**
     * @function setMax
     * @param Carbon $max
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
     * @return Carbon
     */
    public function getMax() : Carbon
    {
        return $this->max ?? new Carbon('9999-12-31 23:59:59');
    }


    /**
     * @function compareValues
     * @param Carbon $a
     * @param Carbon $b
     * @return int
     */
    public function compareValues($a, $b): int
    {
        return $a <=> $b;
    }
}
