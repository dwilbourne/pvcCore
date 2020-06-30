<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\msg;

use Countable;
use Iterator;

/**
 * MsgCollection honors MsgInterface while providing a way to package a group of messages into a single object.
 *
 * Certain libraries will return several errors all at once.  In order to be able to process those errors as a
 * block, this class provides the structure to store multiple messages.
 *
 * Class MsgCollection
 */
class MsgCollection implements Iterator, Countable, MsgInterface
{

    /**
     * @var MsgInterface[]
     */
    protected array $messages = [];

    /**
     * @var int
     */
    private int $pos;

    /**
     * @function addMsg
     * @param MsgInterface $msg
     */
    public function addMsg(MsgInterface $msg): void
    {
        $this->messages[] = $msg;
        $this->rewind();
    }

    /**
     * @function rewind
     */
    public function rewind() : void
    {
        $this->pos = 0;
    }

    /**
     * @function current
     * @return mixed
     */
    public function current()
    {
        return $this->messages[$this->pos];
    }

    /**
     * @function next
     * @return int|void
     */
    public function next()
    {
        return ++$this->pos;
    }

    /**
     * @function key
     * @return bool|float|int|string|null
     */
    public function key()
    {
        return $this->pos;
    }

    /**
     * @function valid
     * @return bool
     */
    public function valid()
    {
        return isset($this->messages[$this->pos]);
    }

    /**
     * @function count
     * @return int|void
     */
    public function count()
    {
        return count($this->messages);
    }

    public function getMsgText(): string
    {
        $msgText = '';
        foreach ($this->messages as $msg) {
            $msgText .= $msg->getMsgText() . PHP_EOL;
        }
        return $msgText;
    }

    public function getMsgVars(): array
    {
        $msgVars = [];
        foreach ($this->messages as $msg) {
            $msgVars[] = $msg->getMsgVars();
        }
        return $msgVars;
    }
}
