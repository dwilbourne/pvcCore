<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\sys;

use pvc\msg\Msg;
use pvc\validator\sys\ValidatorArrayKey;
use PHPUnit\Framework\TestCase;

class ValidatorArrayKeyTest extends TestCase
{
    protected ValidatorArrayKey $validator;

    public function setUp() : void
    {
        $this->validator = new ValidatorArrayKey();
    }

    public function testAllowNullKey() : void
    {
        $this->validator->allowNullKey();
        self::assertTrue($this->validator->nullKeyIsAllowed());

        $this->validator->allowNullKey(false);
        self::assertFalse($this->validator->nullKeyIsAllowed());
    }

    public function testValidateNullKey() : void
    {
        $this->validator->allowNullKey();
        self::assertTrue($this->validator->validate(null));
    }

    public function testIntegerStringKeys() : void
    {
        self::assertTrue($this->validator->validate('foo'));
        self::assertTrue($this->validator->validate(15));
    }

    public function testNullKeyNotAllowed() : void
    {
        self::assertFalse($this->validator->validate(null));
        self::assertTrue($this->validator->getErrMsg() instanceof Msg);
    }
}
