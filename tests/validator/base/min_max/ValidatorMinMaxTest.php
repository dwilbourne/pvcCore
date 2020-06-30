<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\base\min_max;

use Mockery;
use pvc\err\throwable\exception\pvc_exceptions\InvalidTypeException;
use pvc\err\throwable\exception\pvc_exceptions\InvalidValueException;
use pvc\err\throwable\exception\pvc_exceptions\UnsetAttributeException;
use pvc\formatter\FrmtrInterface;
use pvc\msg\ErrorExceptionMsg;
use pvc\msg\Msg;
use pvc\msg\UserMsg;
use pvc\validator\base\data_type\ValidatorType;
use pvc\validator\base\min_max\ValidatorMinMax;
use PHPUnit\Framework\TestCase;

class ValidatorMinMaxTest extends TestCase
{
    /** @phpstan-ignore-next-line */
    protected $vt;

    /** @phpstan-ignore-next-line */
    protected $frmtr;

    /** @phpstan-ignore-next-line */
    protected $validator;

    public function setUp() : void
    {
        $this->vt = Mockery::mock(ValidatorType::class);
        $this->frmtr = Mockery::mock(FrmtrInterface::class);
        $this->validator = Mockery::mock(ValidatorMinMax::class)->makePartial();
        $this->validator->setValidatorType($this->vt);
        $this->validator->setFrmtr($this->frmtr);
        $closure = function (int $a, int $b) {
            return $a <=> $b;
        };
        $this->validator->shouldReceive('compareValues')
                        ->with(
                            Mockery::type('integer'),
                            Mockery::type('integer')
                        )->andReturnUsing($closure);
    }

    public function testSetGetValidatorType() : void
    {
        self::assertEquals($this->vt, $this->validator->getValidatorType());
    }

    public function testSetGetFormatter() : void
    {
        $this->validator->setFrmtr($this->frmtr);
        self::assertSame($this->frmtr, $this->validator->getFrmtr());
    }

    public function testValidateMinFailOnType() : void
    {
        $input = 'foo';
        $msg = Mockery::mock(UserMsg::class);
        $errorExceptionMsg = Mockery::mock(ErrorExceptionMsg::class);
        $msg->shouldReceive('makeErrorExceptionMsg')->withNoArgs()->andReturn($errorExceptionMsg);

        $this->vt->shouldReceive('validate')->with($input)->andReturn(false);
        $this->vt->shouldReceive('getErrmsg')->withNoArgs()->andReturn($msg);
        $this->expectException(InvalidTypeException::class);
        $this->validator->validateMin($input);
    }

    public function testValidateMinFailOnValue() : void
    {
        $input = 5;
        $existingMax = 4;

        $this->vt->shouldReceive('validate')->with($input)->andReturn(true);

        $this->validator->shouldReceive('getMax')->withNoArgs()->andReturn($existingMax);
        $this->validator->shouldReceive('compareValues')->with($input, $existingMax)->andReturn(1);

        $this->frmtr->shouldReceive('format')->with($input)->andReturn("'" . $input . "'");
        $this->expectException(InvalidValueException::class);
        $this->validator->validateMin($input);
    }

    public function testValidateMinSucceedWithExistingMax() : void
    {
        $input = 4;
        $existingMax = 5;

        $this->validator->shouldReceive('getMax')->withNoArgs()->andReturn($existingMax);
        $this->vt->shouldReceive('validate')->with($input)->andReturn(true);
        $this->validator->validateMin($input);
        self::assertTrue(true, 'test finishes without throwing an exception');
    }

    public function testValidateMinSuceedWithNonExistentMax() : void
    {
        $input = 4;
        $this->vt->shouldReceive('validate')->with($input)->andReturn(true);
        $this->validator->shouldReceive('getMax')->withNoArgs()->andReturn(PHP_INT_MAX);
        $this->validator->validateMin($input);
        self::assertTrue(true, 'test finishes without throwing an exception');
    }

    public function testValidateMaxFailOnType() : void
    {
        $input = 'foo';
        $msg = Mockery::mock(UserMsg::class);
        $errorExceptionMsg = Mockery::mock(ErrorExceptionMsg::class);
        $msg->shouldReceive('makeErrorExceptionMsg')->withNoArgs()->andReturn($errorExceptionMsg);

        $this->vt->shouldReceive('validate')->with($input)->andReturn(false);
        $this->vt->shouldReceive('getErrmsg')->withNoArgs()->andReturn($msg);
        $this->expectException(InvalidTypeException::class);
        $this->validator->validateMax($input);
    }

    public function testValidateMaxFailOnValue() : void
    {
        $input = 3;
        $existingMin = 4;

        $this->vt->shouldReceive('validate')->with($existingMin)->andReturn(true);
        $this->validator->shouldReceive('getMin')->withNoArgs()->andReturn($existingMin);
        $this->validator->shouldReceive('compareValues')->with($input, $existingMin)->andReturn(-1);

        $this->vt->shouldReceive('validate')->with($input)->andReturn(true);

        $this->frmtr->shouldReceive('format')->with($input)->andReturn("'" . $input . "'");
        $this->expectException(InvalidValueException::class);
        $this->validator->validateMax($input);
    }

    public function testValidateMaxSucceedWithExistingMin() : void
    {
        $input = 6;
        $existingMin = 5;

        $this->validator->shouldReceive('getMin')->withNoArgs()->andReturn($existingMin);
        $this->vt->shouldReceive('validate')->with($input)->andReturn(true);
        $this->validator->validateMax($input);
        self::assertTrue(true, 'test finishes without throwing an exception');
    }

    public function testSetGetMaxSuceedWithNonExistentMin() : void
    {
        $input = 4;
        $this->validator->shouldReceive('getMin')->withNoArgs()->andReturn(PHP_INT_MIN);
        $this->vt->shouldReceive('validate')->with($input)->andReturn(true);
        $this->validator->validateMax($input);
        self::assertTrue(true, 'test finishes without throwing an exception');
    }

    public function testValidateBadType() : void
    {
        $input = 'foo';
        $this->vt->shouldReceive('validate')->with($input)->andReturn(false);

        $msg = Mockery::mock(UserMsg::class);
        $errorExceptionMsg = Mockery::mock(ErrorExceptionMsg::class);
        $msg->shouldReceive('makeErrorExceptionMsg')->withNoArgs()->andReturn($errorExceptionMsg);

        $this->vt->shouldReceive('validate')->with($input)->andReturn(false);
        $this->vt->shouldReceive('getErrmsg')->withNoArgs()->andReturn($msg);

        $this->expectException(InvalidTypeException::class);
        $this->validator->validate($input);
    }

    public function testValidateFailValueLessThanMin() : void
    {
        $min = 6;
        $input = 5;
        $this->vt->shouldReceive('validate')->with($input)->andReturn(true);
        $this->vt->shouldReceive('validate')->with($min)->andReturn(true);
        $this->frmtr->shouldReceive('format')->with($input)->andReturn("'" . $input . "'");
        $this->frmtr->shouldReceive('format')->with($min)->andReturn("'" . $min . "'");
        $this->validator->shouldReceive('getMin')->withNoArgs()->andReturn($min);
        self::assertFalse($this->validator->validate($input));
        self::assertTrue($this->validator->getErrmsg() instanceof UserMsg);
    }

    public function testValidateFailValueGreaterThanMax() : void
    {
        $min = 6;
        $max = 10;
        $input = 12;

        $this->vt->shouldReceive('validate')->with($input)->andReturn(true);
        $this->vt->shouldReceive('validate')->with($min)->andReturn(true);
        $this->vt->shouldReceive('validate')->with($max)->andReturn(true);

        $this->frmtr->shouldReceive('format')->with($input)->andReturn("'" . $input . "'");
        $this->frmtr->shouldReceive('format')->with($max)->andReturn("'" . $max . "'");

        $this->validator->shouldReceive('getMin')->withNoArgs()->andReturn($min);
        $this->validator->shouldReceive('getMax')->withNoArgs()->andReturn($max);

        self::assertFalse($this->validator->validate($input));
        self::assertTrue($this->validator->getErrmsg() instanceof UserMsg);
    }

    public function testValidateSucceed() : void
    {
        $min = 6;
        $max = 10;
        $input = 8;

        $this->vt->shouldReceive('validate')->with($input)->andReturn(true);
        $this->vt->shouldReceive('validate')->with($min)->andReturn(true);
        $this->vt->shouldReceive('validate')->with($max)->andReturn(true);

        $this->validator->shouldReceive('getMin')->withNoArgs()->andReturn($min);
        $this->validator->shouldReceive('getMax')->withNoArgs()->andReturn($max);

        self::assertTrue($this->validator->validate($input));
    }
}
