<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\doctype;

use pvc\doctype\DocType;
use PHPUnit\Framework\TestCase;
use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentException;
use pvc\validator\document\html\ValidatorHtmlNodes;

class DocTypeTest extends TestCase
{
    protected DocType $doctype;

    public function setUp() : void
    {
        $this->doctype = new DocType(DocType::HTML5);
    }

    public function testSetDoctypeException() : void
    {
        self::expectException(InvalidArgumentException::class);
        $this->doctype->setDocType(1001);
    }

    public function testSetGetDocType() : void
    {
        self::assertEquals(DocType::HTML5, $this->doctype->getDocType());
    }

    public function testGetMarkupLanguage() : void
    {
        $this->doctype->setDocType(DocType::HTML4_LOOSE);
        self::assertEquals('html', $this->doctype->getMarkupLanguage());

        $this->doctype->setDocType(DocType::HTML4_STRICT);
        self::assertEquals('html', $this->doctype->getMarkupLanguage());

        $this->doctype->setDocType(DocType::HTML5);
        self::assertEquals('html', $this->doctype->getMarkupLanguage());

        $this->doctype->setDocType(DocType::XML);
        self::assertEquals('xml', $this->doctype->getMarkupLanguage());
    }

    public function testGetDocTypeString() : void
    {
        $dtHtml4Loose = '';
        $dtHtml4Loose .= '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" ';
        $dtHtml4Loose .= '"http://www.w3.org/TR/html4/loose.dtd">';

        $dtHtml4Strict = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
        $dtHtml5 = '<!DOCTYPE html>';
        $dtXml = '';

        $this->doctype->setDocType(DocType::HTML4_LOOSE);
        self::assertEquals($dtHtml4Loose, $this->doctype->getDocTypeString());

        $this->doctype->setDocType(DocType::HTML4_STRICT);
        self::assertEquals($dtHtml4Strict, $this->doctype->getDocTypeString());

        $this->doctype->setDocType(DocType::HTML5);
        self::assertEquals($dtHtml5, $this->doctype->getDocTypeString());

        $this->doctype->setDocType(DocType::XML);
        self::assertEquals($dtXml, $this->doctype->getDocTypeString());
    }
}
