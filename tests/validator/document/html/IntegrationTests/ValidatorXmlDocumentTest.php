<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\document\html\IntegrationTests;

use pvc\validator\document\html\ValidatorXmlDocument;
use PHPUnit\Framework\TestCase;

class ValidatorXmlDocumentTest extends TestCase
{
    protected string $fixturesDir;
    protected ValidatorXmlDocument $validator;

    public function setUp() : void
    {
        $this->fixturesDir = dirname(__DIR__) . '/fixtures/';
        $this->validator = new ValidatorXmlDocument();
    }

    public function testValidateSvg() : void
    {
        $documentString  = file_get_contents($this->fixturesDir . 'document-valid-xml.xml') ?: '';
        $this->validator->loadXXE(true);
        self::assertTrue($this->validator->validate($documentString));
    }

    // looks like validator will not validate documents that declare a default namespace
    // which is not publicly registered
    public function testValidateNote() : void
    {
        $documentString  = file_get_contents($this->fixturesDir . 'note.xml') ?: '';
        $this->validator->loadXXE(true);
        self::assertFalse($this->validator->validate($documentString));
    }
}
