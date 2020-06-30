<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\document\html\UnitTests;

use PHPUnit\Framework\TestCase;
use pvc\validator\document\html\HttpClient;
use pvc\validator\document\html\ValidatorXmlDocument;

/**
 * Class ValidatorXmlNodesTest
 */
class ValidatorXmlDocumentTest extends TestCase
{
    public function testSetGetLoadXXE() : void
    {
        $v = new ValidatorXmlDocument();
        self::assertFalse($v->getLoadXXE());
        $v->loadXXE(true);
        self::assertTrue($v->getLoadXXE());
    }

    public function testConfigureRequest() : void
    {
        $doc = '<moo>cow</moo>';
        $expectedMethod = HttpClient::REQUEST_POST;
        $v = new ValidatorXmlDocument();
        $v->configureRequest($doc);
        self::assertEquals($doc, $v->getClient()->getDocument());
        self::assertEquals($expectedMethod, $v->getClient()->getRequestMethod());
    }

    public function testConfigureRequestLoadXXE() : void
    {
        $doc = '<moo>cow</moo>';
        $v = new ValidatorXmlDocument();
        $v->loadXXE(true);
        $v->configureRequest($doc);
        $queryArray = $v->getClient()->createQueryArray();
        self::assertEquals('xmldtd', $queryArray['parser']);
    }

    //public function testConfigureRequestAddSchemas() { : void

    //}
}
