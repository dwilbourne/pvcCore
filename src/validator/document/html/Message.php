<?php declare(strict_types = 1);
/**
 * This file is part of the pvc\htmlValidator package, whic is an adaptation of the
 * rexxars\html-validator package authored by Espen Hovlandsdal <espen@hovlandsdal.com>.
 *
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version 1.0
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace pvc\validator\document\html;

use pvc\msg\MsgInterface;

/**
 * This object categorizes messagesFilter into 4 buckets: informational messagesFilter, warnings, and errors and fatal
 * errors. This grouping is referred to as the "reportingLevel" below.  The values of the corresponding constants
 * can be ORed together to form a bitmask of whatever combination of errors you wish to report back.
 * e.g. (MESSAGE_TYPE_INFO | MESSAGE_TYPE_WARNING)
 *
 * Class Message
 */
class Message implements MsgInterface
{

    public const MESSAGE_TYPE_INFO = 1;
    public const MESSAGE_TYPE_WARNING = 2;
    public const MESSAGE_TYPE_ERROR = 4;
    public const MESSAGE_TYPE_ERROR_FATAL = 8;
    // shorthand for setting the reporting level to all message types
    public const MESSAGE_TYPE_ALL = 15;

    /**
     * @var int
     */
    private int $reportingLevel;

    /**
     * @var string
     */
    private string $type;

    /**
     * @var string
     */
    private string $subtype;

    /**
     * @var string
     */
    private string $message;

    /**
     * @var string
     */
    private string $extract;

    /**
     * @var int
     */
    private int $offset;

    /**
     * @var string
     */
    private string $url;

    /**
     * @var int
     */
    private int $firstLine;

    /**
     * @var int
     */
    private int $lastLine;

    /**
     * @var int
     */
    private int $firstColumn;

    /**
     * @var int
     */
    private int $lastColumn;

    /**
     * @var int
     */
    private int $hiliteStart;

    /**
     * @var int
     */
    private int $hiliteLength;

    /**
     * @var array
     */
    private array $defaults = [
        'type' => '',
        'subtype' => '',
        'message' => '',
        'extract' => '',
        'offset' => 0,
        'url' => '',
        'lastLine' => 0,
        'firstColumn' => 0,
        'lastColumn' => 0,
        'hiliteStart' => 0,
        'hiliteLength' => 0,
    ];

    /**
     * Message constructor.
     * @param array $info
     */
    public function __construct(array $info = [])
    {
        $info = array_merge($this->defaults, $info);
        $this->type = $info['type'];
        $this->subtype = ($info['subtype'] ?? '');

        $this->message = $info['message'];
        $this->extract = $info['extract'];
        $this->offset = $info['offset'];
        $this->url = $info['url'];

        $this->firstLine = isset($info['firstLine']) ? $info['firstLine'] : $info['lastLine'];
        $this->lastLine = $info['lastLine'];
        $this->firstColumn = $info['firstColumn'];
        $this->lastColumn = $info['lastColumn'];
        $this->hiliteStart = $info['hiliteStart'];
        $this->hiliteLength = $info['hiliteLength'];

        $this->setReportingLevel();
    }

    /**
     * @function setReportingLevel
     */
    protected function setReportingLevel(): void
    {
        switch ($this->type) {
            case 'info':
                $this->reportingLevel = ($this->subtype == 'warning') ?
                    self::MESSAGE_TYPE_WARNING : self::MESSAGE_TYPE_INFO;
                break;
            case 'error':
                $this->reportingLevel = ($this->subtype == 'fatal') ?
                    self::MESSAGE_TYPE_ERROR_FATAL : self::MESSAGE_TYPE_ERROR;
                break;
            // this is not perfectly clear but the api documentation says that the parser was not able to complete
            // its parsing of the document.  The problem could be internal to the document but it could also
            // be some sort of server error or i/o error....
            case 'non-document-error':
                $this->reportingLevel = self::MESSAGE_TYPE_ERROR_FATAL;
                break;
        }
    }

    /**
     * @function getReportingLevel
     * @return int
     */
    public function getReportingLevel() : int
    {
        return $this->reportingLevel;
    }

    /**
     * @function getReportingLevelText
     * @return string
     */
    public function getReportingLevelText() : string
    {
        $result = '';
        switch ($this->getReportingLevel()) {
            case self::MESSAGE_TYPE_INFO:
                $result = 'INFO';
                break;
            case self::MESSAGE_TYPE_WARNING:
                $result = 'WARNING';
                break;
            case self::MESSAGE_TYPE_ERROR:
                $result = 'ERROR';
                break;
            case self::MESSAGE_TYPE_ERROR_FATAL:
                $result = 'ERROR (FATAL)';
                break;
        }
        return $result;
    }

    /**
     * @function getType
     * @return string
     */
    public function getType() : string
    {
        return $this->type;
    }

    /**
     * @function getSubType
     * @return string
     */
    public function getSubType() : string
    {
        return $this->subtype;
    }

    /**
     * @function getFirstLine
     * @return int|mixed
     */
    public function getFirstLine()
    {
        return $this->firstLine;
    }

    /**
     * @function getLastLine
     * @return int|mixed
     */
    public function getLastLine()
    {
        return $this->lastLine;
    }

    /**
     * @function getFirstColumn
     * @return int|mixed
     */
    public function getFirstColumn()
    {
        return $this->firstColumn;
    }

    /**
     * @function getLastColumn
     * @return int|mixed
     */
    public function getLastColumn()
    {
        return $this->lastColumn;
    }

    /**
     * @function getMessage
     * @return mixed|string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @function getExtract
     * @return mixed|string
     */
    public function getExtract()
    {
        return $this->extract;
    }

    /**
     * @function getOffset
     * @return int|mixed
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @function getUrl
     * @return string
     */
    public function getUrl() : string
    {
        return $this->url;
    }

    /**
     * @function getHighlightStart
     * @return int|mixed
     */
    public function getHighlightStart()
    {
        return $this->hiliteStart;
    }

    /**
     * @function getHighlightLength
     * @return int|mixed
     */
    public function getHighlightLength()
    {
        return $this->hiliteLength;
    }

    /**
     * @function shouldBeReported
     * @param int $flags
     * @return bool
     */
    public function shouldBeReported($flags) : bool
    {
        return (0 < ($this->reportingLevel & $flags));
    }

    /**
     * @function getMsgText
     * @return string
     */
    public function getMsgText(): string
    {
        return $this->getMessage();
    }

    /**
     * @function getMsgVars
     * @return mixed[]
     */
    public function getMsgVars(): array
    {
        return [
          $this->getType(),
          $this->getSubType(),
          $this->getExtract(),
          $this->getOffset(),
          $this->getUrl(),
          $this->getFirstLine(),
          $this->getLastLine(),
          $this->getFirstColumn(),
          $this->getLastColumn(),
          $this->getHighlightStart(),
          $this->getHighlightLength()
        ];
    }
}
