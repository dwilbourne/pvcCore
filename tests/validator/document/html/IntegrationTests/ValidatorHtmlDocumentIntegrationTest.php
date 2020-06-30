<?php

namespace tests\validator\document\html\IntegrationTests;

use PHPUnit\Framework\TestCase;
use pvc\validator\document\html\Message;
use pvc\validator\document\html\ValidatorHtmlDocument;

class ValidatorHtmlDocumentIntegrationTest extends TestCase
{
    protected string $fixturesDir;
    protected ValidatorHtmlDocument $validator;

    public function setUp() : void
    {
        $this->fixturesDir = dirname(__DIR__) . '/fixtures/';
        $this->validator = new ValidatorHtmlDocument();
    }

    public function testCanValidateUtf8Html5Document() : void
    {
        $documentString  = file_get_contents($this->fixturesDir . 'document-valid-utf8-html5.html') ?: '';
        self::assertTrue($this->validator->validate($documentString));
        self::assertEquals(0, count($this->validator->getMessages()));
    }

    public function testCanValidateXmlDocument() : void
    {
        $documentString  = file_get_contents($this->fixturesDir . 'document-valid-xml.xml') ?: '';
        self::assertTrue($this->validator->validate($documentString));
        $messages = $this->validator->getMessages();
        self::assertEquals(2, count($messages));
        foreach ($messages as $message) {
            // there are two informational messagesFilter that are returned as part of the validation
            self::assertEquals(Message::MESSAGE_TYPE_INFO, $message->getReportingLevel());
        }
    }

    public function testCanValidateHtml4Document() : void
    {
        // html4 documents produce an error condition (they are obsolete) but this is not a fatal error
        $documentString  = file_get_contents($this->fixturesDir . 'document-valid-html4.html') ?: '';
        $this->validator->setFailureThreshold(Message::MESSAGE_TYPE_ERROR_FATAL);
        self::assertTrue($this->validator->validate($documentString));

        $messagesFilter = $this->validator->getMessagesFilter();
        $messagesFilter->setReportingLevel(Message::MESSAGE_TYPE_ERROR);
        static::assertCount(1, $messagesFilter);
        $message = $messagesFilter->getMessage(0) ?: new Message();
        static::assertSame('Obsolete doctype. Expected “<!DOCTYPE html>”.', $message->getMessage());
        $messagesFilter->setReportingLevel(Message::MESSAGE_TYPE_WARNING);
        static::assertCount(0, $messagesFilter, 'Valid HTML document should produce no warnings');
    }

    public function testDetectsErrorsOnInvalidHtml5() : void
    {
        $documentString  = file_get_contents($this->fixturesDir . 'document-invalid-utf8-html5.html') ?: '';
        $this->validator->setFailureThreshold(Message::MESSAGE_TYPE_ERROR);
        self::assertFalse($this->validator->validate($documentString), 'Invalid HTML5 should produce errors');

        // is the badly formed html (extra </span> tag) a fatal error? no
        $this->validator->setFailureThreshold(Message::MESSAGE_TYPE_ERROR_FATAL);
        self::assertTrue($this->validator->validate($documentString), 'Invalid HTML5 should produce errors');

        // Can't guarantee order of messagesFilter
        $strayTagFound = false;
        foreach ($this->validator->getMessages() as $message) {
            $strayTagFound = $strayTagFound || strpos($message->getMessage(), 'Stray end tag “span”.') !== false;
        }
        static::assertTrue($strayTagFound, 'Stray <span>-tag was not discovered by validator found');
    }

    public function testDetectsErrorsOnInvalidXml() : void
    {
        $documentString  = file_get_contents($this->fixturesDir . 'document-invalid-xml.xml') ?: '';
        self::assertFalse($this->validator->validate($documentString));

        // Can't guarantee order of messagesFilter, but assume this one won't go away
        $nameExpectedFound = false;
        foreach ($this->validator->getMessages() as $message) {
            $nameExpectedFound = $nameExpectedFound || ($message->getMessage() === 'name expected');
        }
        static::assertTrue($nameExpectedFound, '"name expected"-message was not found');
    }

    public function testDetectsErrorsOnInvalidHtml4() : void
    {
        $documentString  = file_get_contents($this->fixturesDir . 'document-invalid-html4.html') ?: '';
        // produces a non-fatal error
        $this->validator->setFailureThreshold(Message::MESSAGE_TYPE_ERROR);
        self::assertFalse($this->validator->validate($documentString));

        $strayTagFound = false;
        foreach ($this->validator->getMessages() as $message) {
            $strayTagFound = $strayTagFound || strpos($message->getMessage(), 'Stray end tag “span”.') !== false;
        }
        static::assertTrue($strayTagFound, 'Stray <span>-tag was not discovered by validator found');
    }
}
