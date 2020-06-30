<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\formatter\date_time;

use Carbon\Carbon;
use pvc\intl\Locale;
use pvc\intl\TimeZone;
use pvc\validator\base\data_type\ValidatorTypeCarbonDateTime;

/**
 * Class FrmtrDateAbstract
 */
abstract class FrmtrDateAbstract extends FrmtrDateTimeAbstract
{
    /**
     * @var TimeZone
     */
    protected TimeZone $timezone;

    /**
     * FrmtrDateAbstract constructor.
     * @param Locale $locale
     * @param TimeZone $timeZone
     */
    public function __construct(Locale $locale = null, TimeZone $timeZone = null)
    {
        $locale = ($locale ?: new Locale());
        $timeZone = ($timeZone ?: new TimeZone());

        parent::__construct($locale);
        $this->setTimezone($timeZone);
        $this->setTypeValidator(new ValidatorTypeCarbonDateTime());
    }

    /**
     * @function getTimezone
     * @return TimeZone
     */
    public function getTimezone(): TimeZone
    {
        return $this->timezone;
    }

    /**
     * @function setTimezone
     * @param TimeZone $timezone
     */
    public function setTimezone(TimeZone $timezone): void
    {
        $this->timezone = $timezone;
    }

    /**
     * @function formatValue
     * @param Carbon $value
     * @return string
     */
    public function formatValue($value): string
    {
        if (!isset($this->format)) {
            $this->setFormat($this->getPatternFromLocale());
        }
        // value is a carbon object
        return $value->format($this->getFormat());
    }
}
