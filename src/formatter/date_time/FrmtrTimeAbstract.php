<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\formatter\date_time;

use Carbon\Carbon;
use pvc\formatter\FrmtrInterface;
use pvc\intl\Locale;
use pvc\intl\UtcOffset;
use pvc\time\Time;
use pvc\validator\base\data_type\ValidatorTypeTime;

/**
 * Class FrmtrTime
 */
abstract class FrmtrTimeAbstract extends FrmtrDateTimeAbstract implements FrmtrInterface
{

    /**
     * @var UtcOffset
     */
    protected UtcOffset $utcOffset;

    /**
     * FrmtrTimeAbstract constructor.
     * @param Locale $locale
     * @param UtcOffset $utcOffset
     */
    public function __construct(Locale $locale, UtcOffset $utcOffset)
    {
        parent::__construct($locale);
        $this->setUtcOffset($utcOffset);
        $this->setTypeValidator(new ValidatorTypeTime());
    }

    /**
     * @function formatValue
     * @param Time $value
     * @return string
     */
    public function formatValue($value): string
    {
        if (!isset($this->format)) {
            $this->setFormat($this->getPatternFromLocale());
        }
        $carbon = Carbon::createFromTimestamp(
            $value->getTimestamp() +
            $this->getUtcOffset()->getUtcOffsetSeconds(),
            'UTC'
        );
        return $carbon->format($this->getFormat());
    }

    /**
     * @function getUtcOffset
     * @return UtcOffset
     */
    public function getUtcOffset(): UtcOffset
    {
        return $this->utcOffset;
    }

    /**
     * @function setUtcOffset
     * @param UtcOffset $utcOffset
     */
    public function setUtcOffset(UtcOffset $utcOffset): void
    {
        $this->utcOffset = $utcOffset;
    }
}
