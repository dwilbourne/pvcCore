<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\sys;

use pvc\msg\MsgInterface;
use pvc\validator\sys\ValidatorFilenameWindows;
use PHPUnit\Framework\TestCase;

class ValidatorFilenameWindowsTest extends TestCase
{
    protected ValidatorFilenameWindows $v;

    public function setUp() : void
    {
        $this->v = new ValidatorFilenameWindows();
    }

    public function testConstruct() : void
    {
        $array = $this->v->getValidatorArray();
        self::assertEquals(3, count($array));
    }

    // do a couple of basic tests but the regex inside the ValidatorText object is unit tested separately
    public function testValidate() : void
    {
        self::assertFalse($this->v->validate(5432));
        self::assertFalse($this->v->validate(null));
        self::assertFalse($this->v->validate(""));
        self::assertTrue($this->v->validate('some filename'));
    }

    public function testSetErrmsg() : void
    {
        self::assertFalse($this->v->validate('a"c'));
        self::assertTrue($this->v->getErrMsg() instanceof MsgInterface);
    }
}
