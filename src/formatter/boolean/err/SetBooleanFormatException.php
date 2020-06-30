<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\formatter\boolean\err;

use pvc\err\throwable\ErrorExceptionConstants as ec;
use pvc\err\throwable\exception\stock_rebrands\Exception;
use pvc\msg\ErrorExceptionMsg;
use Throwable;

/**
 * Class InvalidBooleanFormatException
 */
class SetBooleanFormatException extends Exception
{
    public function __construct(string $format, Throwable $previous = null)
    {
        $msgVars = [$format];
        $msgText = 'Argument to setFormat must be the positive of a positive / negative pair (e.g. yes, true, 1)';
        $msg = new ErrorExceptionMsg($msgVars, $msgText);
        $code = ec::SET_BOOLEAN_FORMAT_EXCEPTION;
        parent::__construct($msg, $code, $previous);
    }
}
