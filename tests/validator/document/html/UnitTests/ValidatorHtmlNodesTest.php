<?php
/**
 * This file is part of the html-validator package.
 *
 * (c) Espen Hovlandsdal <espen@hovlandsdal.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace tests\validator\document\html\UnitTests;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use pvc\charset\Charset;
use pvc\doctype\DocType;
use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentException;
use pvc\validator\document\html\HttpClient;
use pvc\validator\document\html\ValidatorHtmlNodes;

class ValidatorHtmlNodesTest extends TestCase
{
    protected ValidatorHtmlNodes $validator;

    public function setUp() : void
    {
        $this->validator = new ValidatorHtmlNodes();
    }

    public function testSetGetDocType() : void
    {
        $dt = new DocType(DocType::HTML5);
        $this->validator->setDocType($dt);
        self::assertEquals($dt->getDocTypeString(), $this->validator->getDocType());
    }

    public function testSetInvalidDoctypeException() : void
    {
        $dt = new DocType(DocType::XML);
        self::expectException(InvalidArgumentException::class);
        $this->validator->setDocType($dt);
    }

    public function testSetGetCharset() : void
    {
        $charsetConstant = Charset::CENTRAL_EUROPEAN_MAC;
        $charset = new Charset($charsetConstant);
        $this->validator->setCharSet($charset);
        self::assertEquals($charset->getCharsetString(), $this->validator->getCharSet());
    }

    /**
     * Ensure the HTML5 validator can wrap a single HTML5 node correctly
     */
    public function testWrapsSingleHtml5NodeCorrectly(): void
    {
        $nodes = '<p>Moo</p>';
        $wrapped = $this->validator->wrap($nodes);

        // Document should start with doctype html
        static::assertSame(0, strpos($wrapped, '<!DOCTYPE html>'));

        // Ensure body tag has been inserted
        // (I know, regex and such: DOMDocument fails on meta charset tag)
        static::assertSame(1, preg_match('/(<body[^>]*>.*<\/body>)/s', $wrapped, $groups));
        static::assertSame(2, count($groups));

        // Load the body into a DOMDocument
        $document = new DOMDocument();
        $document->loadXML($groups[1]);

        // phpstan cannot know about the DOM structure and complains that some of these accessors could return null
        // It shouldn't insert more than the node we gave it
        /** @phpstan-ignore-next-line */
        static::assertEquals(1, $document->firstChild->childNodes->length);
        // The "<p>" node should exist and have the correct value
        /** @phpstan-ignore-next-line */
        static::assertEquals('p', $document->firstChild->firstChild->nodeName);
        /** @phpstan-ignore-next-line */
        static::assertEquals('Moo', $document->firstChild->firstChild->nodeValue);
    }

    /**
     * Ensure the HTML5 validator can wrap multiple HTML5 nodes correctly
     */
    public function testWrapsMultipleHtml5NodeCorrectly() : void
    {
        $nodes = '<p>Foo</p><p>Bar</p>';
        $wrapped = $this->validator->wrap($nodes);

        // Document should start with doctype html
        static::assertSame(0, strpos($wrapped, '<!DOCTYPE html>'));

        // Ensure body tag has been inserted
        // (I know, regex and such: DOMDocument fails on meta charset tag)
        static::assertSame(1, preg_match('/(<body[^>]*>.*<\/body>)/si', $wrapped, $groups));
        static::assertSame(2, count($groups));

        // Load the body into a DOMDocument
        $document = new DOMDocument();
        $document->loadXML($groups[1]);

        // It should insert both nodes that we gave it
        /** @phpstan-ignore-next-line */
        static::assertEquals(2, $document->firstChild->childNodes->length);

        // The "<p>" nodes should exist and have the correct values
        /** @phpstan-ignore-next-line */
        static::assertEquals('p', $document->firstChild->firstChild->nodeName);
        /** @phpstan-ignore-next-line */
        static::assertEquals('Foo', $document->firstChild->firstChild->nodeValue);

        /** @phpstan-ignore-next-line */
        static::assertEquals('p', $document->firstChild->lastChild->nodeName);
        /** @phpstan-ignore-next-line */
        static::assertEquals('Bar', $document->firstChild->lastChild->nodeValue);
    }

    /**
     * Ensure the HTML5 validator uses the passed charset
     */
    public function testWrapsHtml5NodesInGivenCharset() : void
    {
        $cs = new Charset(Charset::ISO_8859_1);
        $this->validator->setCharSet($cs);
        $nodes = '<span>Moo</span>';
        $wrapped = $this->validator->wrap($nodes);

        // Expecting: <meta charset="iso-8859-1">
        static::assertSame(1, preg_match('/<meta[^>]*charset=[\'"](.*?)[\'"]/i', $wrapped, $groups));
        static::assertSame(2, count($groups));

        static::assertEquals($cs->getCharsetString(), $groups[1]);
    }

    /**
     * ================================================================
     * ========================== [ HTML4 ] ===========================
     * ================================================================
     */

    /**
     * Ensure the HTML4 validator can wrap a single HTML4 node correctly
     */
    public function testWrapsSingleHtml4NodeCorrectly() : void
    {
        $dt = new DocType(DocType::HTML4_STRICT);
        $this->validator->setDocType($dt);
        $nodes = '<p>Moo</p>';
        $wrapped = $this->validator->wrap($nodes);

        // Document should start with HTML4 doctype
        $doctype = $dt->getDocTypeString();
        static::assertSame(0, strpos($wrapped, $doctype), 'Document did not start with HTML4 doctype');

        // Ensure body tag has been inserted
        // (I know, regex and such: DOMDocument fails on meta charset tag)
        static::assertSame(1, preg_match('/(<body[^>]*>.*<\/body>)/s', $wrapped, $groups));
        static::assertSame(2, count($groups));

        // Load the body into a DOMDocument
        $document = new DOMDocument();
        $document->loadXML($groups[1]);

        // It shouldn't insert more than the node we gave it
        /** @phpstan-ignore-next-line */
        static::assertEquals(1, $document->firstChild->childNodes->length);

        // The "<p>" node should exist and have the correct value
        /** @phpstan-ignore-next-line */
        static::assertEquals('p', $document->firstChild->firstChild->nodeName);
        /** @phpstan-ignore-next-line */
        static::assertEquals('Moo', $document->firstChild->firstChild->nodeValue);
    }

    /**
     * Ensure the HTML4 validator can wrap multiple HTML4 nodes correctly
     */
    public function testWrapsMultipleHtml4NodeCorrectly() : void
    {
        $dt = new DocType(DocType::HTML4_STRICT);
        $this->validator->setDocType($dt);
        $nodes = '<p>Foo</p><p>Bar</p>';
        $wrapped = $this->validator->wrap($nodes);

        // Document should start with the HTML4 doctype
        $doctype = $dt->getDocTypeString();
        static::assertSame(0, strpos($wrapped, $doctype), 'Document did not start with HTML4 doctype');

        // Ensure body tag has been inserted
        // (I know, regex and such: DOMDocument fails on meta charset tag)
        static::assertSame(1, preg_match('/(<body[^>]*>.*<\/body>)/si', $wrapped, $groups));
        static::assertSame(2, count($groups));

        // Load the body into a DOMDocument
        $document = new DOMDocument();
        $document->loadXML($groups[1]);

        // It should insert both nodes that we gave it
        /** @phpstan-ignore-next-line */
        static::assertEquals(2, $document->firstChild->childNodes->length);

        // The "<p>" nodes should exist and have the correct values
        /** @phpstan-ignore-next-line */
        static::assertEquals('p', $document->firstChild->firstChild->nodeName);
        /** @phpstan-ignore-next-line */
        static::assertEquals('Foo', $document->firstChild->firstChild->nodeValue);

        /** @phpstan-ignore-next-line */
        static::assertEquals('p', $document->firstChild->lastChild->nodeName);
        /** @phpstan-ignore-next-line */
        static::assertEquals('Bar', $document->firstChild->lastChild->nodeValue);
    }

    /**
     * Ensure the HTML4 validator uses the passed charset
     */
    public function testWrapsHtml4NodesInGivenCharset() : void
    {
        $dt = new DocType(DocType::HTML4_STRICT);
        $cs = new Charset(Charset::ISO_8859_1);

        $this->validator->setDocType($dt);
        $this->validator->setCharSet($cs);

        $nodes = '<span>Moo</span>';
        $wrapped = $this->validator->wrap($nodes);

        // Expecting: <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        static::assertSame(1, preg_match('/<meta[^>]+charset=(.*)">/iU', $wrapped, $groups));
        static::assertSame(2, count($groups));

        static::assertEquals($cs->getCharsetString(), $groups[1]);
    }


    /**
     * Ensure the HTML4-TR validator can wrap a single HTML4 node correctly
     */
    public function testWrapsSingleHtml4TrNodeCorrectly() : void
    {
        $dt = new DocType(DocType::HTML4_LOOSE);
        $this->validator->setDocType($dt);
        $nodes = '<p>Moo</p>';
        $wrapped = $this->validator->wrap($nodes);

        // Document should start with HTML4 transitional doctype
        $doctype = $dt->getDocTypeString();
        static::assertSame(0, strpos($wrapped, $doctype));

        // Ensure body tag has been inserted
        // (I know, regex and such: DOMDocument fails on meta charset tag)
        static::assertSame(1, preg_match('/(<body[^>]*>.*<\/body>)/s', $wrapped, $groups));
        static::assertSame(2, count($groups));

        // Load the body into a DOMDocument
        $document = new DOMDocument();
        $document->loadXML($groups[1]);

        // It shouldn't insert more than the node we gave it
        /** @phpstan-ignore-next-line */
        static::assertEquals(1, $document->firstChild->childNodes->length);

        // The "<p>" node should exist and have the correct value
        /** @phpstan-ignore-next-line */
        static::assertEquals('p', $document->firstChild->firstChild->nodeName);
        /** @phpstan-ignore-next-line */
        static::assertEquals('Moo', $document->firstChild->firstChild->nodeValue);
    }

    /**
     * Ensure the HTML4-TR validator can wrap multiple HTML4 nodes correctly
     */
    public function testWrapsMultipleHtml4TrNodeCorrectly() : void
    {
        $dt = new DocType(DocType::HTML4_LOOSE);
        $cs = new Charset(Charset::ISO_8859_1);

        $this->validator->setDocType($dt);
        $this->validator->setCharSet($cs);

        $nodes = '<p>Foo</p><p>Bar</p>';
        $wrapped = $this->validator->wrap($nodes);

        // Document should start with the HTML4 transitional doctype
        $doctype = $dt->getDocTypeString();
        static::assertSame(0, strpos($wrapped, $doctype));

        // Ensure body tag has been inserted
        // (I know, regex and such: DOMDocument fails on meta charset tag)
        static::assertSame(1, preg_match('/(<body[^>]*>.*<\/body>)/si', $wrapped, $groups));
        static::assertSame(2, count($groups));

        // Load the body into a DOMDocument
        $document = new DOMDocument();
        $document->loadXML($groups[1]);

        // It should insert both nodes that we gave it
        /** @phpstan-ignore-next-line */
        static::assertEquals(2, $document->firstChild->childNodes->length);

        // The "<p>" nodes should exist and have the correct values
        /** @phpstan-ignore-next-line */
        static::assertEquals('p', $document->firstChild->firstChild->nodeName);
        /** @phpstan-ignore-next-line */
        static::assertEquals('Foo', $document->firstChild->firstChild->nodeValue);

        /** @phpstan-ignore-next-line */
        static::assertEquals('p', $document->firstChild->lastChild->nodeName);
        /** @phpstan-ignore-next-line */
        static::assertEquals('Bar', $document->firstChild->lastChild->nodeValue);
    }

    /**
     * Ensure the HTML4-TR validator uses the passed charset
     */
    public function testWrapsHtml4TrNodesInGivenCharset() : void
    {
        $dt = new DocType(DocType::HTML4_LOOSE);
        $cs = new Charset(Charset::ISO_8859_1);

        $this->validator->setDocType($dt);
        $this->validator->setCharSet($cs);

        $nodes = '<span>Moo</span>';
        $wrapped = $this->validator->wrap($nodes);

        // Expecting: <meta http-equiv="Content-Type" content="text/html; charset='ISO-8859-1'">
        static::assertSame(1, preg_match('/<meta[^>]+charset=(.*?)">/iU', $wrapped, $groups));
        static::assertSame(2, count($groups));

        static::assertEquals($cs->getCharsetString(), $groups[1]);
    }

    public function testConfigureRequest() : void
    {
        $nodes = 'any old string';
        $expectedMethod = HttpClient::REQUEST_POST;
        $expectedDocument = $this->validator->wrap($nodes);
        $this->validator->configureRequest($nodes);
        self::assertEquals($expectedDocument, $this->validator->getClient()->getDocument());
        self::assertEquals($expectedMethod, $this->validator->getClient()->getRequestMethod());
    }
}
