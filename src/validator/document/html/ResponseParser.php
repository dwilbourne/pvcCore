<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\document\html;

use pvc\msg\UserMsg;
use pvc\msg\UserMsgInterface;
use pvc\parser\ParserInterface;
use pvc\msg\MsgInterface;
use pvc\validator\document\html\err\ResponseContentMsg;

/**
 * Class ResponseParser
 */

class ResponseParser implements ParserInterface
{

    /**
     * @var Messages
     */
    protected Messages $messages;

    /**
     * @var UserMsg
     */
    protected UserMsg $errmsg;

    /**
     * ResponseParser constructor.
     * @param Messages $messages
     */
    public function __construct(Messages $messages)
    {
        $this->setMessages($messages);
    }

    /**
     * @function getMessages
     * @return Messages
     */
    public function getMessages(): Messages
    {
        return $this->messages;
    }

    /**
     * @function setMessages
     * @param Messages $messages
     */
    public function setMessages(Messages $messages): void
    {
        $this->messages = $messages;
    }

    /**
     * Parse the received response into a usable format
     * @function parse
     * @param string $data
     * @return bool
     */
    public function parse(string $data) : bool
    {
        $data = json_decode($data, true);
        if (json_last_error()) {
            $this->errmsg = new ResponseContentMsg('json', json_last_error_msg());
            return false;
        }

        /**
         * the output from the checker is a bit complicated (can be found at
         * https://github.com/validator/validator/wiki/Output-%C2%BB-JSON).
         *
         * $data has several top-level indices: url, messagesFilter, source and language.
         * this parser is only concerned with the messagesFilter.
         *
         */

        foreach ($data['messages'] as $message) {
            $msg = new Message($message);
            $this->messages->addMsg($msg);
        }
        return true;
    }

    /**
     * @function getParsedValue
     * @return Messages
     */
    public function getParsedValue()
    {
        return $this->messages;
    }

    /**
     * This method is required by the interface but there is no code that ever actually sets an error message.
     * @function getErrMsg
     * @return UserMsgInterface|null
     */
    public function getErrmsg(): ?UserMsgInterface
    {
        return $this->errmsg;
    }
}
