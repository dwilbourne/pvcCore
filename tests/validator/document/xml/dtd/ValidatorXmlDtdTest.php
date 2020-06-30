<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\document\xml\dtd;

use DOMDocument;
use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentException;
use pvc\msg\MsgInterface;
use pvc\validator\document\xml\dtd\ValidatorXmlDtd;
use PHPUnit\Framework\TestCase;

/**
 * Class ValidatorXmlDtdTest
 */
class ValidatorXmlDtdTest extends TestCase
{
    protected ValidatorXmlDtd $validator;
    protected string $fixturesDir;

    public function setUp() : void
    {
        $this->validator = new ValidatorXmlDtd();
        $this->fixturesDir = __DIR__ . '/fixtures/';
    }

    public function testValidInternalDtd() : void
    {
        $filename = 'xml-valid-DTD-internal.xml';
        $fileContents = file_get_contents($this->fixturesDir . $filename) ?: '';
        $doc = new DOMDocument();
        $doc->loadXML($fileContents);
        self::assertTrue($this->validator->validate($doc));
        self::assertEmpty($this->validator->getLibXmlErrors());
    }

    public function testInvalidInternalDtd() : void
    {
        $filename = 'xml-invalid-DTD-internal.xml';
        $fileContents = file_get_contents($this->fixturesDir . $filename) ?: '';
        $doc = new DOMDocument();
        $doc->loadXML($fileContents);
        self::assertFalse($this->validator->validate($doc));
        self::assertNotEmpty($this->validator->getLibXmlErrors());
        self::assertInstanceOf(MsgInterface::class, $this->validator->getErrMsg());
    }

    public function testValidExternalDtdRemote() : void
    {
        $filename = 'xml-valid-DTD-external.xml';
        $fileContents = file_get_contents($this->fixturesDir . $filename) ?: '';
        $doc = new DOMDocument();
        $doc->loadXML($fileContents);
        self::assertTrue($this->validator->validate($doc));
        self::assertEmpty($this->validator->getLibXmlErrors());
    }

    public function testBadArgument() : void
    {
        $doc = 'foo';
        self::expectException(InvalidArgumentException::class);
        /** @phpstan-ignore-next-line */
        $foo = $this->validator->validate($doc);
    }

    public function testHtmlArgument() : void
    {
        $filename = 'html4-valid.html';
        $fileContents = file_get_contents($this->fixturesDir . $filename) ?: '';
        $doc = new DOMDocument();
        $doc->loadHTML($fileContents);
        self::expectException(InvalidArgumentException::class);
        $foo = $this->validator->validate($doc);
    }

    public function testDocumentClaimsToBeHtmlWithoutDocTypeSet() : void
    {
        $doc = new DOMDocument();
        self::assertFalse($this->validator->documentClaimsToBeHtml($doc));
    }
}
