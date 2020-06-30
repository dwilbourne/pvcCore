<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\intl\err;

use pvc\err\throwable\exception\stock_rebrands\Exception;
use pvc\msg\ErrorExceptionMsg;
use Throwable;
use pvc\err\throwable\ErrorExceptionConstants as ec;

/**
 * Class UtcOffsetException
 */
class UtcOffsetException extends Exception
{
    public function __construct(ErrorExceptionMsg $msg, int $code = 0, Throwable $previous = null)
    {
        if ($code == 0) {
            $code = ec::INVALID_UTC_OFFSET;
        }
        parent::__construct($msg, $code, $previous);
    }
}
