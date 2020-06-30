<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\document\xml\schema\err;

use pvc\msg\ErrorExceptionMsg;
use pvc\err\throwable\exception\stock_rebrands\Exception;
use pvc\err\throwable\ErrorExceptionConstants as ec;
use pvc\err\throwable\Throwable;

/**
 * Class ValidateSchemaException
 */
class ValidateSchemaException extends Exception
{
    /**
     * ValidateSchemaException constructor.
     * @param Throwable|null $previous
     */
    public function __construct(Throwable $previous = null)
    {
        $vars = [];
        $msgText = 'There were no schemas set against which to validate the xml document.';
        $msg = new ErrorExceptionMsg($vars, $msgText);
        $code = ec::VALIDATE_SCHEMA_EXCEPTION;
        parent::__construct($msg, $code, $previous);
    }
}
