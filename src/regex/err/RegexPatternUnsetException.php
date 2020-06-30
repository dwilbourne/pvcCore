<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\regex\err;

use pvc\err\throwable\ErrorExceptionConstants as ec;
use pvc\msg\ErrorExceptionMsg;
use pvc\err\throwable\exception\pvc_exceptions\UnsetAttributeException;
use Throwable;

/**
 * Class RegexPatternUnsetException
 */
class RegexPatternUnsetException extends UnsetAttributeException
{
    public function __construct(Throwable $previous = null)
    {
        $msgText = 'pattern attribute not set - must set pattern before running match method.';
        $vars = [];
        $msg = new ErrorExceptionMsg($vars, $msgText);
        $code = ec::REGEX_UNSET_PATTERN_EXCEPTION;
        parent::__construct($msg, $code, $previous);
    }
}
