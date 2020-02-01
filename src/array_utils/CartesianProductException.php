<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\array_utils;


use pvc\err\throwable\ErrorExceptionMsg;
use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentException;
use pvc\err\throwable\ErrorExceptionConstants as ec;
use Throwable;

/**
 * Class CartesianProductException
 */
class CartesianProductException extends InvalidArgumentException {

    function __construct(Throwable $previous=null) {
        $msgText = 'Each element in the array of the constructor must be itself an array or must implement Iterator interface.  Each set must have more than zero elements.';
        $vars = array();
        $msg = new ErrorExceptionMsg($vars, $msgText);
        $code = ec::CARTESIAN_PRODUCT_EXCEPTION;
        parent::__construct($msg, $code, $previous);
    }

}