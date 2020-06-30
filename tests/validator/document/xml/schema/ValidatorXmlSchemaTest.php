<?php

namespace tests\validator\document\xml\schema;

use DOMDocument;
use LibXMLError;
use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentException;
use pvc\msg\MsgInterface;
use pvc\validator\document\xml\schema\err\BuildSchemasException;
use pvc\validator\document\xml\schema\err\ValidateSchemaException;
use pvc\validator\document\xml\schema\Schemas;

class ValidatorXmlSchemaTest extends TestCase
{
    public function testSetGetSchemas() : void
    {
        $schemas = new Schemas();
        $this->validator->setSchemas($schemas);
        $msg = 'original object and retrieved object are the same';
        self::assertEquals($schemas, $this->validator->getSchemas(), $msg);
    }

    public function testAddSchema() : void
    {
        $this->validator->addSchema('someNamespace', 'someUriLocation');
        self::assertEquals(1, count($this->validator->getSchemas()));
    }

    public function testBuildSchemasFromDocumentThatHasNoPrefixForW3SchemaInstance() : void
    {
        $doc = $this->getDocument('no-schema-instance.xml');
        self::assertFalse($this->validator->buildSchemasFromDocument($doc), 'no schemas in document to build');
    }

    public function testBuildSchemasFromDocumentThatHasNoSchemaLocations() : void
    {
        $doc = $this->getDocument('no-schema-locations.xml');
        $msg = 'no schema locations in document to build';
        self::assertFalse($this->validator->buildSchemasFromDocument($doc), $msg);
    }

    public function testBuildSchemasFromDocumentThatHasNoSchemaLocationAttributes() : void
    {
        $doc = $this->getDocument('no-schema-locations-attributes.xml');
        $msg = 'no schema location attributes in document to build';
        self::assertFalse($this->validator->buildSchemasFromDocument($doc), $msg);
    }

    public function testBuildSchemasFromDocumentWithSingleValidSchema() : void
    {
        $doc = $this->getDocument('books-valid.xml');
        self::assertTrue($this->validator->buildSchemasFromDocument($doc), 'build returns true');
        $msg = 'should be one schema in the schemas attribute';
        self::assertEquals(1, $this->validator->schemaCount(), $msg);
    }

    public function testBuildWithVariousWhitespaceInSchemaDeclaration() : void
    {
        $doc = $this->getDocument('books-valid-with-extra-whitespace-in-schema-declaration.xml');
        self::assertTrue($this->validator->buildSchemasFromDocument($doc), 'build returns true');
        $msg = 'should be one schema in the schemas attribute';
        self::assertEquals(1, $this->validator->schemaCount(), $msg);
    }

    public function testBuildSchemasFromDocumentWithMultipleValidSchemas() : void
    {
        $doc = $this->getDocument('ticket-valid.xml');
        self::assertTrue($this->validator->buildSchemasFromDocument($doc), 'build returns true');
        $msg = 'should be two schemas in the schemas attribute';
        self::assertEquals(2, $this->validator->schemaCount(), $msg);
    }

    public function testBuildSchemasFromDocumentThatOddNumberOfSchemaLocationAttributes() : void
    {
        $doc = $this->getDocument('not-even-schemalocations.xml');
        self::expectException(BuildSchemasException::class);
        $this->validator->buildSchemasFromDocument($doc);
    }

    public function testValidateWithBadArgument() : void
    {
        $badArgument = 'foo';
        self::expectException(InvalidArgumentException::class);
        /** @phpstan-ignore-next-line */
        $this->validator->validate($badArgument);
    }

    public function testValidateWithNoSchemas() : void
    {
        $doc = $this->getDocument('no-schema-instance.xml');
        self::expectException(ValidateSchemaException::class);
        // no schemas built from document or set in the validator object: throw an exception
        $this->validator->validate($doc);
    }

    public function testValidateAgainstLocalSchema() : void
    {
        $doc = $this->getDocument('note.xml');
        $xsd = static::filesystemFixtureLocation('note.xsd');
        self::assertTrue($doc->schemaValidate($xsd));
    }

    public function testValidateUsingBuiltSchemas() : void
    {
        $doc = $this->getDocument('books-valid.xml');
        self::assertTrue($this->validator->validate($doc));
    }

    public function testGetLibXmlErrorsAndErrmsg() : void
    {
        $doc = new DOMDocument('1.0');
        $docText = '<moo>cow</moo>';
        $doc->loadXML($docText);

        $schemas = new Schemas();
        $namespace = "http://www.sat.gob.mx/cfd/3";
        $location = "http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv32.xsd";
        $schemas->create($namespace, $location);

        $this->validator->setSchemas($schemas);
        self::assertFalse($this->validator->validate($doc));
        $errors = $this->validator->getLibXmlErrors();
        foreach ($errors as $error) {
            self::assertInstanceOf(LibXMLError::class, $error);
        }
        self::assertInstanceOf(MsgInterface::class, $this->validator->getErrMsg());
    }

    public function testGetLastErrorTextIsNull() : void
    {
        // no errors set
        self::assertNull($this->validator->getLastErrorText());
    }
}
