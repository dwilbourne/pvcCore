<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\formatter\numeric;

use Locale;
use NumberFormatter;

/**
 * Class FrmtrCurrency
 */
class FrmtrCurrency extends FrmtrFloat
{
    protected function createDefaultFormatter(): NumberFormatter
    {
        $locale = Locale::getDefault();
        return new NumberFormatter($locale, NumberFormatter::CURRENCY);
    }
}
