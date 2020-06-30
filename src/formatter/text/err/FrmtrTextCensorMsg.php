<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\formatter\text\err;

use pvc\err\throwable\exception\pvc_exceptions\InvalidValueMsg;

/**
 * Class FrmtrTextCensorMsg
 */
class FrmtrTextCensorMsg extends InvalidValueMsg
{

    /**
     * FrmtrTextCensorMsg constructor.
     * @param string $name
     * @param int $value
     */
    public function __construct(string $name, int $value)
    {
        $addtlMsg = 'must be an integer greater than 0';
        parent::__construct($name, $value, $addtlMsg);
    }
}
