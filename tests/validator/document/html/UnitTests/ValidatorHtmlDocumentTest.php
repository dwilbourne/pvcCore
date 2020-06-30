<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\document\html\UnitTests;

use pvc\validator\document\html\HttpClient;
use pvc\validator\document\html\ValidatorHtmlDocument;
use PHPUnit\Framework\TestCase;

class ValidatorHtmlDocumentTest extends TestCase
{
    public function testConfigureRequest() : void
    {
        $doc = 'any old string';
        $expectedMethod = HttpClient::REQUEST_POST;
        $v = new ValidatorHtmlDocument();
        $v->configureRequest($doc);
        self::assertEquals($doc, $v->getClient()->getDocument());
        self::assertEquals($expectedMethod, $v->getClient()->getRequestMethod());
    }
}
