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
     * addMsgVar
     * @param null $var
     */
    public function addMsgVar($var = null) : void;

    /**
     * setMsgVars
     * @param array $vars
     */
    public function setMsgVars(array $vars) : void;

    /**
     * getMsgVars
     * @return array
     */
    public function getMsgVars() : array;

    /**
     * getMsgText
     * @return string
     */
    public function getMsgText(): string;

    /**
     * setMsgText
     * @param string $msgText
     */
    public function setMsgText(string $msgText): void;

    /**
     * makeErrorExceptionMsg
     * @return ErrorExceptionMsg
     */
    public function makeErrorExceptionMsg(): ErrorExceptionMsg;

    /**
     * makeUserMsg
     * @return UserMsg
     */
    public function makeUserMsg() : UserMsg;

}
