<?php
declare(strict_types=1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\document\html;

use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentException;
use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentMsg;
use pvc\formatter\FrmtrInterface;

/**
 * Class MessageFrmtr
 */
class MessageFrmtrHtml extends MessageFrmtr implements FrmtrInterface
{

    /**
     * @var string
     */
    protected string $highlightClassName;

    /**
     * @var string
     */
    protected string $containerTagClassName = '';

    /**
     * MessageFrmtrHtml constructor.
     * @param string $hiliteClassName
     */
    public function __construct(string $hiliteClassName = 'hilite')
    {
        $this->setHighlightClassName($hiliteClassName);
    }

    /**
     * @function getHighlightClassName
     * @return string
     */
    public function getHighlightClassName(): string
    {
        return $this->highlightClassName;
    }

    /**
     * @function setHighlightClassName
     * @param string $className
     */
    public function setHighlightClassName(string $className): void
    {
        $this->highlightClassName = $className;
    }

    /**
     * @function getContainerTagClassName
     * @return string
     */
    public function getContainerTagClassName(): string
    {
        return $this->containerTagClassName;
    }

    /**
     * @function setContainerTagClassName
     * @param string $className
     */
    public function setContainerTagClassName(string $className) : void
    {
        $this->containerTagClassName = $className;
    }

    /**
     * Format the message in html
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

        $reportingLevel = '<strong>' . $message->getReportingLevelText() . '</strong>';
        $messageText = $this->sanitize($message->getMessage());
        $locatorText = $this->getLocatorText($message);

        $extractParts = $this->parseExtract(
            $message->getExtract(),
            $message->getHighlightStart(),
            $message->getHighlightLength()
        );
        $extractParts = array_map([$this, 'sanitize'], $extractParts);
        $extract = $extractParts['prehighlight'] . $this->highlight(
            $extractParts['highlight'] . $extractParts['posthighlight']
        );

        $result = '';
        $result .= $this->wrapWithContainerTag($reportingLevel);
        $result .= $this->wrapWithContainerTag($messageText);
        $result .= (empty($locatorText) ? '' : $this->wrapWithContainerTag($locatorText));
        $result .= $this->wrapWithContainerTag($extract);
        return $result;
    }

    /**
     * @function sanitize
     * @param string $text
     * @return string
     */
    protected function sanitize(string $text): string
    {
        return htmlentities($text, ENT_COMPAT, 'UTF-8');
    }

    /**
     * @function highlight
     * @param string $part
     * @return string
     */
    protected function highlight(string $part)
    {
        $z = '';
        $z .= (empty($this->highlightClassName) ? '<span>' : '<span class="' . $this->highlightClassName . '">');
        $z .= $part . '</span>';
        return $z;
    }

    /**
     * @function wrapWithContainerTag
     * @param string $part
     * @return string
     */
    protected function wrapWithContainerTag(string $part): string
    {
        $z = '';
        $z .= (empty($this->containerTagClassName) ? '<div>' : '<div class="' . $this->containerTagClassName . '">');
        $z .= $part . '</div>';
        return $z;
    }
}
