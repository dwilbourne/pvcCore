<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\document\html\IntegrationTests;

use pvc\validator\document\html\Message;
use pvc\validator\document\html\ValidatorHtmlRemote;
use PHPUnit\Framework\TestCase;

class ValidatorHtmlRemoteTest extends TestCase
{
    protected ValidatorHtmlRemote $validator;

    public function setUp() : void
    {
        $this->validator = new ValidatorHtmlRemote();
    }

    public function testValidateUrl() : void
    {
        $url = 'https://html-validator-fixtures.netlify.com/document-invalid-utf8-html5.html';
        self::assertFalse($this->validator->validate($url));
        $messages = $this->validator->getMessages();

        // Can't guarantee order of messagesFilter, but assume this one won't go away
        $strayTagFound = false;
        foreach ($messages as $message) {
            $strayTagFound = $strayTagFound || strpos($message->getMessage(), 'Stray end tag “span”.') !== false;
        }

        static::assertTrue($strayTagFound, 'Stray <span>-tag was not discovered by validator found');
    }

    public function testValidateUrlWith404() : void
    {
        self::assertFalse($this->validator->validate('https://www.w3.org/404'));
        $messagesFilter = $this->validator->getMessagesFilter();
        $message = $messagesFilter->getMessage(0) ?: new Message();
        static::assertTrue(strpos($message->getMessage(), '404') !== false);
    }

    public function testValidateUrlWithAllowed404() : void
    {
        $this->validator->setCheckNon200Pages(true);
        /**
         * Interestingly, the 404 page on the W3C website itself triggers an Error condition because the xhtml doctype
         * is an 'almost standards mode' doctype
         * (see https://developer.mozilla.org/en-US/docs/Mozilla/Gecko_Almost_Standards_Mode).
         *
         * here's the doctype for the 404 page on w3.org
         * <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
         * "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
         */
        $this->validator->setFailureThreshold(Message::MESSAGE_TYPE_ERROR_FATAL);
        self::assertTrue($this->validator->validate('https://www.w3.org/404'));
        $messagesFilter = $this->validator->getMessagesFilter();
        $messagesFilter->setFailureThreshold(Message::MESSAGE_TYPE_ERROR);
        self::assertTrue($messagesFilter->exceedFailureThreshold());
    }
}
