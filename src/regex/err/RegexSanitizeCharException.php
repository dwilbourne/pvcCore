<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\regex\err;

use pvc\err\throwable\ErrorExceptionConstants as ec;
use pvc\msg\ErrorExceptionMsg;
use pvc\err\throwable\exception\pvc_exceptions\InvalidValueException;
use Throwable;

/**
 * Class RegexSanitizeCharException
 */
class RegexSanitizeCharException extends InvalidValueException
{
    /**
     * RegexSanitizeCharException constructor.
     * @param mixed $arg
     * @param Throwable|null $previous
     */
    public function __construct($arg, Throwable $previous = null)
    {
        $msgText = 'char argument to sanitizeCharacter must be one character only (argument passed = %s).';
        $vars = [$arg];
        $msg = new ErrorExceptionMsg($vars, $msgText);

        $code = ec::REGEX_SANITIZE_CHAR_EXCEPTION;
        parent::__construct($msg, $code, $previous);
    }
}
