<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\msg;

/**
 * parent class / default implementation for message creation
 *
 * Pvc distinguishes between user messages (see @UserMsg) and error / exception messages
 * (see @ErrorExceptionMsg).  Both of these classes inherit this implementation.
 *
 * Class Msg
 */

class Msg implements MsgInterface
{
    /**
     * @var array
     */
    protected array $msgVars = [];

    /**
     * @var string
     */
    protected string $msgText;


    /**
     * Msg constructor.
     * @param array $vars
     * @param string $msgText
     */
    public function __construct(array $vars = [], string $msgText = '')
    {
        $this->setMsgVars($vars);
        $this->setMsgText($msgText);
    }

    /**
     * @function addMsgVar
     * @param mixed $var
     */
    public function addMsgVar($var = null) : void
    {
        if (empty($var)) {
            $var = '{{ null or empty string }}';
        }
        $this->msgVars[] = $var;
    }

    /**
     * @function countMsgVars
     * @return int
     */
    public function countMsgVars(): int
    {
        return count($this->msgVars);
    }

    /**
     * These next two allow interchangeability between the two message types
     */

    /**
     * @function makeErrorExceptionMsg
     * @return ErrorExceptionMsg
     */
    public function makeErrorExceptionMsg(): ErrorExceptionMsg
    {
        return new ErrorExceptionMsg($this->getMsgVars(), $this->getMsgText());
    }

    /**
     * makeUserMsg
     * @return UserMsg
     */
    public function makeUserMsg() : UserMsg
    {
        return new UserMsg($this->getMsgVars(), $this->getMsgText());
    }

    /**
     * @function getMsgVars
     * @return array
     */
    public function getMsgVars(): array
    {
        return $this->msgVars;
    }

    /**
     * @function setMsgVars
     * @param array $vars
     */
    public function setMsgVars(array $vars) : void
    {
        $this->msgVars = [];
        foreach ($vars as $var) {
            $this->addMsgVar($var);
        }
    }

    /**
     * @function getMsgText
     * @return string
     */
    public function getMsgText(): string
    {
        return $this->msgText;
    }

    /**
     * @function setMsgText
     * @param string $msgText
     */
    public function setMsgText(string $msgText): void
    {
        $this->msgText = $msgText;
    }

    public function __toString()
    {
        return vsprintf($this->getMsgText(), $this->getMsgVars());
    }
}
