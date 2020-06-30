<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\base\required;

use pvc\msg\Msg;
use PHPUnit\Framework\TestCase;
use pvc\validator\base\required\ValidatorNotEmpty;

class ValidatorNotEmptyTest extends TestCase
{
    public function testValidate() : void
    {
        $v = new ValidatorNotEmpty(true);

        self::assertTrue($v->validate('foo'));
        self::assertTrue(is_null($v->getErrMsg()));

        // empty string is empty
        self::assertFalse($v->validate(''));
        self::assertTrue($v->getErrMsg() instanceof Msg);

        // null is empty
        self::assertFalse($v->validate(null));
        self::assertTrue($v->getErrMsg() instanceof Msg);
    }
}
