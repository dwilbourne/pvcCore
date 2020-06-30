<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\msg;

/**
 * Interface MsgInterface
 * @package pvc\msg
 */
interface MsgInterface
{
    /**
     * @function getMsgText
     * @return string
     */
    public function getMsgText() : string;

    /**
     * @function getMsgVars
     * @return mixed[]
     */
    public function getMsgVars() : array;
}
