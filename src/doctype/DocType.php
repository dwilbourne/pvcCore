<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\doctype;

use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentException;
use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentMsg;

/**
 * Doctype  provides a canoncalization of basic document types for use in parsing, validating and producing markup.
 *
 * Class DocType
 */
class DocType
{
    public const HTML4_LOOSE = 1;
    public const HTML4_STRICT = 2;
    public const HTML5 = 3;
    public const XML = 4;

    protected array $validDocTypes = [
        self::HTML4_LOOSE,
        self::HTML4_STRICT,
        self::HTML5,
        self::XML,
    ];

    /**
     * @var int
     */
    protected int $doctype;

    /**
     * DocType constructor.
     * @param int $docTypeConstant
     * @throws InvalidArgumentException
     */
    public function __construct(int $docTypeConstant)
    {
        $this->setDocType($docTypeConstant);
    }

    /**
     * @function getMarkupLanguage
     * @return string
     */
    public function getMarkupLanguage(): string
    {
        return ($this->getDocType() <= 3) ? 'html' : 'xml';
    }

    /**
     * @function getDocType
     * @return int
     */
    public function getDocType(): int
    {
        return $this->doctype;
    }

    /**
     * @function setDocType
     * @param int $docTypeConstant
     * @throws InvalidArgumentException
     */
    public function setDocType(int $docTypeConstant): void
    {
        if (!in_array($docTypeConstant, $this->validDocTypes)) {
            $msg = new InvalidArgumentMsg('doctype constant from the DocType class.');
            throw new InvalidArgumentException($msg);
        }
        $this->doctype = $docTypeConstant;
    }

    /**
     * @function getDocTypeString
     * @return string
     */
    public function getDocTypeString(): string
    {
        switch ($this->doctype) {
            case self::HTML4_LOOSE:
                $publicId = '"-//W3C//DTD HTML 4.01 Transitional//EN"';
                $url = '"http://www.w3.org/TR/html4/loose.dtd"';
                $result = '<!DOCTYPE HTML PUBLIC ' . $publicId . ' ' . $url . '>';
                break;
            case self::HTML4_STRICT:
                $publicId = '"-//W3C//DTD HTML 4.01//EN"';
                $url = '"http://www.w3.org/TR/html4/strict.dtd"';
                $result = '<!DOCTYPE HTML PUBLIC ' . $publicId . ' ' . $url . '>';
                break;
            case self::HTML5:
                $result = '<!DOCTYPE html>';
                break;
            case self::XML:
                $result = '';
                break;
        }
        return $result ?? '';
    }
}
