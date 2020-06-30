<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\document\html\IntegrationTests;

use pvc\doctype\DocType;
use pvc\validator\document\html\Message;
use pvc\validator\document\html\ValidatorHtmlNodes;
use PHPUnit\Framework\TestCase;

class ValidatorHtmlNodesIntegrationTest extends TestCase
{
    protected ValidatorHtmlNodes $validator;

    public function setUp() : void
    {
        $this->validator = new ValidatorHtmlNodes();
    }

    public function testValidateSingleHtml5NodeCorrectly() : void
    {
        $nodes = '<p>Moo</p>';
        self::assertTrue($this->validator->validate($nodes));
    }

    public function testValidateMultipleHtml5NodesCorrectly() : void
    {
        $nodes = '<p>Foo</p><p>Bar</p>';
        self::assertTrue($this->validator->validate($nodes));
    }

    public function testValidateHtml4DocType() : void
    {
        $dt = new DocType(DocType::HTML4_STRICT);
        $this->validator->setDocType($dt);
        // html4 produces an error with severity level error
        $this->validator->setFailureThreshold(Message::MESSAGE_TYPE_ERROR_FATAL);
        $nodes = '<p>Moo</p>';
        self::assertTrue($this->validator->validate($nodes));

        $messagesFilter = $this->validator->getMessagesFilter();
        $messagesFilter->setReportingLevel(Message::MESSAGE_TYPE_ERROR);
        static::assertCount(1, $messagesFilter);
        $message = $messagesFilter->getMessage(0) ?: new Message();
        static::assertSame('Obsolete doctype. Expected “<!DOCTYPE html>”.', $message->getMessage());
        $messagesFilter->setReportingLevel(Message::MESSAGE_TYPE_WARNING);
        static::assertCount(0, $messagesFilter, 'Valid HTML document should produce no warnings');
    }
}
