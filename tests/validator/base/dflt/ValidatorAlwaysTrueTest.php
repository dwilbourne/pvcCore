<?php
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version 1.0
 */

namespace tests\validator\base\dflt;

use pvc\validator\base\dflt\ValidatorAlwaysTrue;
use PHPUnit\Framework\TestCase;

class ValidatorAlwaysTrueTest extends TestCase
{

    protected ValidatorAlwaysTrue $validator;

    public function setUp() : void {
        $this->validator = new ValidatorAlwaysTrue();
    }

    public function testValidate() : void
    {
        self::assertTrue($this->validator->validate('anything'));
        self::assertTrue($this->validator->validate('5'));
        self::assertTrue($this->validator->validate(null));
    }

    public function testGetErrmsg() : void
    {
        self::assertNull($this->validator->getErrMsg());
        // context makes no difference, e.g. whether validation just took place or not
        self::assertTrue($this->validator->validate('anything'));
        self::assertNull($this->validator->getErrMsg());
    }
}
