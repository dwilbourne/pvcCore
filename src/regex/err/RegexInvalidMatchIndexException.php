<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\regex\err;

use pvc\err\throwable\ErrorExceptionConstants as ec;
use pvc\msg\ErrorExceptionMsg;
use pvc\err\throwable\exception\pvc_exceptions\InvalidArrayIndexException;
use Throwable;

/**
 * Class RegexInvalidMatchIndexException
 */
class RegexInvalidMatchIndexException extends InvalidArrayIndexException
{
    /**
     * RegexInvalidMatchIndexException constructor.
     * @param mixed $index
     * @param Throwable|null $previous
     */
    public function __construct($index, Throwable $previous = null)
    {
        $msgText = 'match index error: no such index in the matches array (index = %s).';
        $vars = [$index];
        $msg = new ErrorExceptionMsg($vars, $msgText);
        $code = ec::REGEX_BAD_MATCHES_INDEX_EXCEPTION;
        parent::__construct($msg, $code, $previous);
    }
}
