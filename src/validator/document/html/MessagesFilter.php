<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\document\html;

use Countable;
use FilterIterator;
use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentException;
use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentMsg;
use pvc\msg\MsgInterface;
use pvc\validator\document\html\Message;
use pvc\validator\document\html\Messages;

/**
 * Class MessagesFilter
 */
class MessagesFilter extends FilterIterator implements Countable, MsgInterface
{
    /**
     * @var int
     */
    protected int $filterFlags;

    /**
     * @var int
     */
    protected int $failureThreshold;

    /**
     * MessagesFilter constructor.
     * @param \pvc\validator\document\html\Messages $messages
     * @param int $filterFlags
     * @throws InvalidArgumentException
     */
    public function __construct(Messages $messages, int $filterFlags = Message::MESSAGE_TYPE_ALL)
    {
        $this->setReportingLevel($filterFlags);
        parent::__construct($messages);
    }

    /**
     * @function setReportingLevel
     * @param int $flags
     * @throws InvalidArgumentException
     */
    public function setReportingLevel(int $flags) : void
    {
        if ($flags < 0 || $flags > 15) {
            $msgText = 'a combination of Message Error constants from the HtmlValidator Message class';
            $msg = new InvalidArgumentMsg($msgText);
            throw new InvalidArgumentException($msg);
        } else {
            $this->filterFlags = $flags;
        }
    }

    /**
     * @function getReportingLevel
     * @return int
     */
    public function getReportingLevel() : int
    {
        return $this->filterFlags;
    }

    /**
     * @function accept
     * @return bool
     */
    public function accept()
    {
        $msg = $this->current();
        return $msg->shouldBeReported($this->filterFlags);
    }

    /**
     * @function count
     * @return int
     */
    public function count()
    {
        $i = 0;
        $this->rewind();
        while ($this->valid()) {
            if ($this->accept()) {
                $i++;
            }
            $this->next();
        }
        return $i;
    }

    /**
     * @function getMessage
     * @param int $index
     * @return Message|null
     */
    public function getMessage(int $index) :? Message
    {
        if ($index < 0 || $index > $this->count()) {
            return null;
        }
        $this->rewind();
        for ($i = 0; $i < $index; $i++) {
            $this->next();
        }
        return $this->current();
    }

    /**
     * @function setFailureThreshold
     * @param int $flag
     * @throws InvalidArgumentException
     */
    public function setFailureThreshold(int $flag) : void
    {
        switch ($flag) {
            case Message::MESSAGE_TYPE_INFO:
            case Message::MESSAGE_TYPE_WARNING:
            case Message::MESSAGE_TYPE_ERROR:
            case Message::MESSAGE_TYPE_ERROR_FATAL:
                $this->failureThreshold = $flag;
                break;
            default:
                $msg = new InvalidArgumentMsg('Message Reporting constant from class Messsage');
                throw new InvalidArgumentException($msg);
        }
    }

    /**
     * @function getFailureThreshold
     * @return int
     */
    public function getFailureThreshold() : int
    {
        return $this->failureThreshold;
    }

    /**
     * @function exceedFailureThreshold
     * @return bool
     */
    public function exceedFailureThreshold() : bool
    {
        $messages = $this->getInnerIterator();
        foreach ($messages as $message) {
            if ($message->getReportingLevel() >= $this->failureThreshold) {
                return true;
            }
        }
        return false;
    }

    /**
     * @function getMsgText
     * @return string
     */
    public function getMsgText(): string
    {
        $this->rewind();
        $msgText = '';
        for ($i = 0; $i < $this->count(); $i++) {
            $msgText .= $this->current()->getMessage() . PHP_EOL;
        }
        return $msgText;
    }

    /**
     * @function getMsgVars
     * @return array
     */
    public function getMsgVars(): array
    {
        $this->rewind();
        $msgVars = [];
        for ($i = 0; $i < $this->count(); $i++) {
            $msgVars = $this->current()->getMsgVars();
        }
        return $msgVars;
    }
}
