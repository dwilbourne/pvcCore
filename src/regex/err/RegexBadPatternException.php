<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\regex\err;

use pvc\msg\ErrorExceptionMsg;
use pvc\err\throwable\exception\pvc_exceptions\InvalidValueException;
use pvc\err\throwable\ErrorExceptionConstants as ec;
use Throwable;

/**
 * Class RegexInvalidRegexException
 */
class RegexBadPatternException extends InvalidValueException
{
    public function __construct(Throwable $previous = null)
    {
        $msgText = 'Pattern is not a valid regular expression.';
        $vars = [];
        $msg = new ErrorExceptionMsg($vars, $msgText);
        $code = ec::REGEX_BAD_PATTERN_EXCEPTION;
        parent::__construct($msg, $code, $previous);
    }
}
