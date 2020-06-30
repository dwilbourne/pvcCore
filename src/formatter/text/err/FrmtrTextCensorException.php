<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\formatter\text\err;

use pvc\err\throwable\ErrorExceptionConstants as ec;
use pvc\err\throwable\exception\pvc_exceptions\InvalidValueException;
use pvc\msg\ErrorExceptionMsg;
use Throwable;

/**
 * Class FrmtrTextCensorException
 */
class FrmtrTextCensorException extends InvalidValueException
{
    /**
     * FrmtrTextCensorException constructor.
     * @param ErrorExceptionMsg $msg
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(ErrorExceptionMsg $msg, $code = 0, Throwable $previous = null)
    {
        if ($code == 0) {
            $code = ec::FRMTR_TEXT_CENSOR_EXCEPTION;
        }
        parent::__construct($msg, $code, $previous);
    }
}
