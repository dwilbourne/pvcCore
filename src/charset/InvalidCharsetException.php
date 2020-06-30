<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\charset;

use pvc\err\throwable\ErrorExceptionConstants as ec;
use pvc\err\throwable\exception\stock_rebrands\Exception;
use pvc\msg\ErrorExceptionMsg;
use Throwable;

/**
 * Class InvalidCharsetException
 */
class InvalidCharsetException extends Exception
{
    public function __construct(int $badCharsetConstant, Throwable $previous = null)
    {
        $msgVars = [$badCharsetConstant];
        $msgText = 'Invalid charset supplied.  %s is not a recognized character set constant.';
        $msg = new ErrorExceptionMsg($msgVars, $msgText);
        $code = ec::INVALID_CHARSEST_EXCEPTION;
        parent::__construct($msg, $code, $previous);
    }
}
