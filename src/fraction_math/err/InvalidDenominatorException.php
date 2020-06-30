<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\fraction_math\err;

use pvc\err\throwable\ErrorExceptionConstants as ec;
use pvc\err\throwable\exception\stock_rebrands\Exception;
use pvc\msg\ErrorExceptionMsg;

/**
 * Class InvalidDenominatorException
 */
class InvalidDenominatorException extends Exception
{
    /**
     * InvalidDenominatorException constructor.
     */
    public function __construct()
    {
        $msgText = 'Denominator of a fraction cannot be zero.';
        $msg = new ErrorExceptionMsg([], $msgText);
        $code = ec::INVALID_FRACTION_DENOMINATOR;
        $previous = null;
        parent::__construct($msg, $code, $previous);
    }
}
