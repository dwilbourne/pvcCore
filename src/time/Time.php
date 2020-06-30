<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\time;

/**
 * Class Time
 *
 * allows one to work with times without having to be concerned about some sort of date being associated with it.
 * Examples often surround recurring scheduled events.
 *
 */

class Time
{

    public const MIN_TIME = 0;
    public const MAX_TIME = 86399;

    /**
     * store the time as a number of seconds which ranges between 0 and +86,399.
     * there are 86400 seconds in a day.  The implicit timezone is UTC, e.g. this is
     * a timestamp.
     *
     * @var int
     */
    protected int $time;

    /**
     * Time constructor.
     * @param int $seconds
     */
    public function __construct(int $seconds = 0)
    {
        $this->time = $seconds;
        $this->wrapTime();
    }

    /**
     * @function wrapTime
     */
    protected function wrapTime() : void
    {
        $this->time = $this->time % (60 * 60 * 24);
        if ($this->time < 0) {
            $this->time += 86400;
        }
    }

    /**
     * @function addTime
     * @param int $seconds
     * @return Time
     */
    public function addTime(int $seconds) : Time
    {
        return new Time($this->time + $seconds);
    }

    /**
     * @function getTimestamp
     * @return int
     */
    public function getTimestamp() : int
    {
        return $this->time;
    }
}
