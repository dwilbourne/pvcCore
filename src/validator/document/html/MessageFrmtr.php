<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\document\html;

/**
 * Class MessageFrmtr
 */
abstract class MessageFrmtr
{
    /**
     * @function getLocatorText
     * @param Message $message
     * @return string
     */
    public function getLocatorText(Message $message): string
    {
        if ($message->getLastLine() > 0) {
            $format = 'From line %d, column %d to line %d, column %d';
            $result = sprintf(
                $format,
                $message->getFirstLine(),
                $message->getFirstColumn(),
                $message->getLastLine(),
                $message->getLastColumn()
            );
        } else {
            $result = '';
        }
        return $result;
    }

    /**
     * @function parseExtract
     * @param string $str
     * @param int $start
     * @param int $length
     * @return array
     */
    public function parseExtract(string $str, int $start, int $length) : array
    {
        return [
            'prehighlight' => substr($str, 0, $start),
            'highlight' => substr($str, $start, $length),
            'posthighlight' => substr($str, $start + $length)
        ];
    }
}
