<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\base\data_type;

use Mockery;
use pvc\validator\base\data_type\err\ValidatorTypeMsg;
use pvc\validator\base\data_type\ValidatorType;
use PHPUnit\Framework\TestCase;

class ValidatorTypeTest extends TestCase
{
    public function testValidatorType() : void
    {
        $v = Mockery::mock(ValidatorType::class)->makePartial();
        $type = 'fooType';
        $v->__construct($type);
        self::assertEquals($type, $v->getDataType());

        $testArg = 'anyArg';
        $v->expects('ValidateType')->with($testArg)->andReturns(true);
        self::assertTrue($v->validate($testArg));

        $nextArg = 'someOtherArg';
        $v->expects('ValidateType')->with($nextArg)->andReturns(false);
        self::assertFalse($v->validate($nextArg));
        self::assertTrue($v->getErrmsg() instanceof ValidatorTypeMsg);
    }
}
