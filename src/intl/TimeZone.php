<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\intl;

use Carbon\CarbonTimeZone;
use pvc\intl\err\InvalidTimezoneException;
use pvc\intl\err\InvalidTimezoneMsg;
use Throwable;

/**
 * Wrapper for Carbon's Timezone class
 *
 * Class TimeZone
 */
class TimeZone extends CarbonTimeZone
{
    /**
     * TimeZone constructor.
     * @param string|null $timezone
     * @throws InvalidTimezoneException
     */
    public function __construct(string $timezone = null)
    {
        try {
            parent::__construct($timezone);
        } catch (Throwable $e) {
            $msg = new InvalidTimezoneMsg((string) $timezone);
            throw new InvalidTimezoneException($msg, 0, $e);
        }
    }

    public static function exists(string $tz): bool
    {
        return in_array($tz, timezone_identifiers_list());
    }
}
