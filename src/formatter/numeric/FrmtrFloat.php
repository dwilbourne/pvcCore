<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\formatter\numeric;

use Locale;
use NumberFormatter;
use pvc\err\throwable\exception\pvc_exceptions\InvalidValueException;
use pvc\err\throwable\exception\pvc_exceptions\InvalidValueMsg;
use pvc\validator\base\data_type\ValidatorTypeFloat;

/**
 * Class FrmtrFloat
 */
class FrmtrFloat extends FrmtrNumberFormatter
{

    /**
     * FrmtrFloat constructor.
     */
    public function __construct()
    {
        $this->setFormatter($frmtr = $this->createDefaultFormatter());
        $this->setTypeValidator(new ValidatorTypeFloat());
    }

    /**
     * @function createDefaultFormatter
     * @return NumberFormatter
     */
    protected function createDefaultFormatter(): NumberFormatter
    {
        $locale = Locale::getDefault();
        return new NumberFormatter($locale, NumberFormatter::DECIMAL);
    }

    /**
     * @function setDecimalPlaces
     * @param int $decimalPlaces
     * @throws InvalidValueException
     */
    public function setDecimalPlaces(int $decimalPlaces): void
    {
        if ($decimalPlaces < 0) {
            $addtlMsgText = 'Number of decimal places must be greater than or equal to 0.';
            $msg = new InvalidValueMsg('decimalPlaces', $decimalPlaces, $addtlMsgText);
            throw new InvalidValueException($msg);
        }
        $this->frmtr->setAttribute(NumberFormatter::FRACTION_DIGITS, $decimalPlaces);
    }

    /**
     * @function getDecimalPlaces
     * @return int
     */
    public function getDecimalPlaces(): int
    {
        return $this->frmtr->getAttribute(NumberFormatter::FRACTION_DIGITS);
    }

    /**
     * @function formatValue
     * @param float $x
     * @return string
     */
    protected function formatValue($x): string
    {
        return $this->frmtr->format($x);
    }
}
