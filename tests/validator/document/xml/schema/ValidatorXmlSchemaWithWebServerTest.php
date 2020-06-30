<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\document\xml\schema;

use GuzzleHttp\Client;
use pvc\validator\document\xml\schema\Schemas;

class ValidatorXmlSchemaWithWebServerTest extends TestCase
{


    /**
     * construction of a web server to resolve the URIs in the fixture files is outside the scope of this
     * test.  The test fixture files themselves contain URIs that refer to schema documents and the URIs are of the
     * form 'http://localhost:8999/filename.xsd'.  The document root for the web server should be the fixtures directory
     * upon which these tests depend, and the fixtures directory is (typically) just below the directory containing
     * this test. If you are developing on a Unix box, you can bootstrap these tests with the file bootstrap.php
     * located in the same directory as this test.
     *
     * Or you can create an Apache instance (virtual host) for localhost listening on port 8999
     * (make sure the httpd.conf has both the Listen directive as well as the VirtualHost directive configured
     * for port 8999 or whatever port you choose).  Using localhost as the the hostname insures you do ont have
     * to configure DNS for resolving your hostname.
     *
     * You can also run the test more or less manually by spinning up a php web server at a command prompt
     * (e.g. php -S localhost:8999 -t /path/to/fixtures/dir).
     */

    protected string $hostnamePort = 'localhost:8999';


    protected function urlFixtureLocation(string $filename) : string
    {
        return  'http://' . $this->hostnamePort . '/' . $filename;
    }

    // sanity check.  make sure your web server is working properly and can find books.xsd
    public function test200() : void
    {
        $client = new Client(['http_errors' => false]);
        $requestUri = $this->urlFixtureLocation('books.xsd');
        $response = $client->request("GET", $requestUri);
        static::assertEquals(200, $response->getStatusCode());
    }

    public function testValidateValidXmlWithLocalSchemasSetManually() : void
    {
        $doc = $this->getDocument('books-valid.xml');
        $xsdLocation = $this->urlFixtureLocation('books.xsd');
        $schemas = new Schemas();
        $schemas->create('http://test.org/schemas/books', $xsdLocation);
        $this->validator->setSchemas($schemas);
        $msg = 'validate using manually set schemas should not throw an exception';
        static::assertTrue($this->validator->validate($doc), $msg);
    }

    public function testValidateValidXmlWithLocalSchemasBuiltFromDocument() : void
    {
        $doc = $this->getDocument('books-valid.xml');
        self::assertTrue($this->validator->buildSchemasFromDocument($doc));
        $msg = 'validate using schemas built from document did not throw any exception';
        self::assertTrue($this->validator->validate($doc), $msg);
    }

    public function testValidateValidXmlWithDefaultNamespace() : void
    {
        $doc = $this->getDocument('note.xml');
        self::assertTrue($this->validator->buildSchemasFromDocument($doc));
        $msg = 'validate xml with default namespace did not throw an exception';
        self::assertTrue($this->validator->validate($doc), $msg);
    }


    public function testValidateInvalidXmlOnlyOneSchema() : void
    {
        $doc = $this->getDocument('books-invalid.xml');
        $this->validator->buildSchemasFromDocument($doc);
        self::assertFalse($this->validator->validate($doc));
        $string = "The attribute 'serie' is required but missing";
        static::assertStringContainsString($string, $this->validator->getLastErrorText() ?: '');
    }


    public function testValidateInvalidXmlFirstSchemas() : void
    {
        $doc = $this->getDocument('ticket-invalid-ticket.xml');
        $this->validator->buildSchemasFromDocument($doc);
        self::assertFalse($this->validator->validate($doc));
        $string = "The attribute 'total' is required but missing";
        static::assertStringContainsString($string, $this->validator->getLastErrorText() ?: '');
    }


    public function testValidateInvalidXmlSecondSchemas() : void
    {
        $doc = $this->getDocument('ticket-invalid-book.xml');
        $this->validator->buildSchemasFromDocument($doc);
        static::assertFalse($this->validator->validate($doc));
        $string = "The attribute 'serie' is required but missing";
        static::assertStringContainsString($string, $this->validator->getLastErrorText() ?: '');
    }

    public function testValidateWithEmptySchema() : void
    {
        $doc = $this->getDocument('books-valid.xml');
        $schemas = new Schemas();
        $schemas->create('//test.org/schemas/books', static::filesystemFixtureLocation('empty.xsd'));
        $this->validator->setSchemas($schemas);
        self::assertFalse($this->validator->validate($doc));
        $string = "Document is empty";
        static::assertStringContainsString($string, $this->validator->getLastErrorText() ?: '');
    }
}
