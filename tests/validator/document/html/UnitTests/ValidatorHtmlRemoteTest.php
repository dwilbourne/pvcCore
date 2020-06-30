<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\document\html\UnitTests;

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

    public function testSetGetCheckNon200Pages() : void
    {
        self::assertFalse($this->validator->getCheckNon200Pages());
        $this->validator->setCheckNon200Pages(true);
        self::assertTrue($this->validator->getCheckNon200Pages());
    }
}
