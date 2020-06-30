<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\base\required;

use pvc\msg\Msg;
use PHPUnit\Framework\TestCase;
use pvc\validator\base\required\ValidatorNotNull;

class ValidatorNotNullTest extends TestCase
{
    public function testValidate() : void
    {
        $v = new ValidatorNotNull(true);

        self::assertTrue($v->validate('foo'));
        self::assertTrue(is_null($v->getErrMsg()));

        // empty string is empty but does not equal (===) null
        self::assertTrue($v->validate(''));
        self::assertTrue(is_null($v->getErrMsg()));

        self::assertFalse($v->validate(null));
        self::assertTrue($v->getErrMsg() instanceof Msg);
    }
}
