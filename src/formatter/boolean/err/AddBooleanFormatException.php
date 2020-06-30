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
class AddBooleanFormatException extends Exception
{
    public function __construct(string $duplicatedString, Throwable $previous = null)
    {
        $msgVars = [$duplicatedString];
        $msgText = 'True / False strings must be different.';
        $msg = new ErrorExceptionMsg($msgVars, $msgText);
        $code = ec::INVALID_BOOLEAN_FORMAT_EXCEPTION;
        parent::__construct($msg, $code, $previous);
    }
}
