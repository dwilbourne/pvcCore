<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\intl;

use pvc\intl\err\UtcOffsetException;
use pvc\intl\err\UtcOffsetMsg;

/**
 * UtcOffset checks to make sure that the offset specified is valid.
 *
 * Offset can be specified in hours or seconds
 *
 * Class UtcOffset
 */
class UtcOffset
{
    public const MIN_OFFSET_SECONDS = -43200;
    public const MAX_OFFSET_SECONDS = 50400;
    /**
     * @var int
     */
    protected int $utcOffsetSeconds;

    /**
     * @function getUtcOffsetSeconds
     * @return int
     */
    public function getUtcOffsetSeconds(): int
    {
        return $this->utcOffsetSeconds;
    }

    /**
     * The number of seconds offset to UTC / GMT.
     *
     * @function setUtcOffsetSeconds
     * @param int $utcOffsetSeconds
     * @throws UtcOffsetException
     */
    public function setUtcOffsetSeconds(int $utcOffsetSeconds): void
    {
        if ($utcOffsetSeconds < self::MIN_OFFSET_SECONDS || $utcOffsetSeconds > self::MAX_OFFSET_SECONDS) {
            $errorMsg = new UtcOffsetMsg($utcOffsetSeconds);
            throw new UtcOffsetException($errorMsg);
        }
        $this->utcOffsetSeconds = $utcOffsetSeconds;
    }

    /**
     * @function setUtcOffsetHours
     * @param int $utcOffsetHours
     * @throws UtcOffsetException
     */
    public function setUtcOffsetHours(int $utcOffsetHours): void
    {
        $this->setUtcOffsetSeconds($utcOffsetHours * 3600);
    }
}
