<?php declare(strict_types = 1);

namespace pvc\validator\document\xml\schema\err;

use pvc\msg\ErrorExceptionMsg;
use pvc\err\throwable\exception\stock_rebrands\Exception;
use pvc\err\throwable\Throwable;
use pvc\err\throwable\ErrorExceptionConstants as ec;

/**
 * Class BuildSchemasException
 */
class BuildSchemasException extends Exception
{
    /**
     * BuildSchemasException constructor.
     * @param string $schemaLocationContent
     * @param Throwable|null $previous
     */
    public function __construct(string $schemaLocationContent, Throwable $previous = null)
    {
        $vars = [$schemaLocationContent];
        $msgText = 'The schemaLocation value must have even number of URIs. Content = %s';
        $msg = new ErrorExceptionMsg($vars, $msgText);
        $code = ec::BUILD_SCHEMAS_EXCEPTION;
        parent::__construct($msg, $code, $previous);
    }
}
