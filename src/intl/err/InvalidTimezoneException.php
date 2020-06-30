<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\intl\err;

use pvc\err\throwable\ErrorExceptionConstants as ec;
use pvc\err\throwable\exception\stock_rebrands\Exception;
use pvc\msg\ErrorExceptionMsg;
use pvc\msg\Msg;
use Throwable;

/**
 * Class InvalidTimezoneException
 */
class InvalidTimezoneException extends Exception
{
    /**
     * InvalidTimezoneException constructor.
     * @param ErrorExceptionMsg $errmsg
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(ErrorExceptionMsg $errmsg, int $code = 0, Throwable $previous = null)
    {
        $code = ec::INVALID_TIMEZONE_EXCEPTION;
        parent::__construct($errmsg, $code, $previous);
    }
}
