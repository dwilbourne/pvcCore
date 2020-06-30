<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\document\html;

use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentException;
use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentMsg;
use pvc\formatter\FrmtrInterface;
use pvc\validator\document\html\Message;
use pvc\validator\document\html\MessageFrmtr;

/**
 * Class MessageFrmtrText
 */
class MessageFrmtrText extends MessageFrmtr implements FrmtrInterface
{

    /**
     * @function format
     * @param Message $message
     * @return string
     * @throws InvalidArgumentException
     */
    public function format($message): string
    {
        if (!$message instanceof Message) {
            $msg = new InvalidArgumentMsg(Message::class);
            throw new InvalidArgumentException($msg);
        }

        $reportingLevel = $message->getReportingLevelText() . PHP_EOL;
        $messageText = $message->getMessage() . PHP_EOL;
        $locatorText = $this->getLocatorText($message);
        if (!empty($locatorText)) {
            $locatorText .= PHP_EOL;
        }
        $extract = $message->getExtract();

        return $reportingLevel . $messageText . $locatorText . $extract;
    }
}
