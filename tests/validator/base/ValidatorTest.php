<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\base;

use Mockery;
use PHPUnit\Framework\TestCase;

use pvc\msg\Msg;
use pvc\msg\UserMsg;
use pvc\validator\base\data_type\ValidatorType;
use pvc\validator\base\Validator;

class ValidatorTest extends TestCase
{
    /** @phpstan-ignore-next-line */
    protected $validator;

    /** @phpstan-ignore-next-line */
    protected $validatorType;

    /** @phpstan-ignore-next-line */
    protected $errmsg;

    public function setUp() : void
    {
        $this->validator = Mockery::mock(Validator::class)->makePartial();
        $this->validator->setRequired(true);
        $this->validatorType = Mockery::mock(ValidatorType::class);
        $this->validator->push($this->validatorType);
        $this->errmsg = Mockery::mock(UserMsg::class);
    }

    public function testSetGetIsRequired() : void
    {
        $this->validator->setRequired();
        self::assertTrue($this->validator->isRequired());

        $this->validator->setRequired(false);
        self::assertFalse($this->validator->isRequired());
    }

    public function testValidatorGetArray() : void
    {
        $array = $this->validator->getValidatorArray();
        self::assertEquals(1, count($array));
        self::assertEquals($array[0], $this->validatorType);
    }

    public function testValidateSucceedsOnNullWhenRequiredIsFalse() : void
    {
        $this->validator->setRequired(false);
        $input = null;
        self::assertTrue($this->validator->validate($input));
    }

    public function testValidateFailsOnType() : void
    {
        $testInput = 'foo';
        $this->validatorType->expects('validate')->with($testInput)->andReturns(false);
        $this->validatorType->expects('getErrmsg')->withNoArgs()->andReturns($this->errmsg);
        self::assertFalse($this->validator->validate($testInput));
        self::assertSame($this->errmsg, $this->validator->getErrMsg());
    }

    public function testValidateFailsOnNull() : void
    {
        $testInput = null;
        $this->validatorType->expects('validate')->with($testInput)->andReturns(true);
        self::assertFalse($this->validator->validate($testInput));
        self::assertTrue($this->validator->getErrMsg() instanceof Msg);
    }

    public function testValidateSucceedsOnEmptyString() : void
    {
        $testInput = '';
        $this->validatorType->expects('validate')->with($testInput)->andReturns(true);
        self::assertTrue($this->validator->validate($testInput));
    }

    public function testValidateSucceed() : void
    {
        $testInput = 'foo';
        $this->validatorType->expects('validate')->with($testInput)->andReturns(true);
        self::assertTrue($this->validator->validate($testInput));
    }
}
