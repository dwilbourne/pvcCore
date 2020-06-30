<?php declare(strict_types = 1);

namespace pvc\err\throwable\exception\stock_rebrands;

use pvc\err\throwable\ErrorExceptionConstants as ec;
use pvc\msg\ErrorExceptionMsg;
use Throwable;

/**
 *
 * Bad function call exceptions should be thrown when you try to invoke a callback where the callback
 * function is not defined or some arguments are bad / missing.
 *
 * The PHP library does not use this exception itself (it throws an error instead in the above circumstance),
 * so this exception can only be generated by throwing it explicitly in your code.
 *
 * Example:
 *
 * function my_array_walk($array, $callback) {
 *        if (!is_callable($callback)) {
 *            throw new pvc\BadFunctionCallException($callback);
 *        }
 *        return array_walk($array, $callback);
 *    }
 *
 */
class BadFunctionCallException extends Exception
{
    public function __construct(ErrorExceptionMsg $msg, int $code, Throwable $previous = null)
    {
        if ($code == 0) {
            $code = ec::BAD_FUNCTION_CALL_EXCEPTION;
        }
        parent::__construct($msg, $code, $previous);
    }
}
