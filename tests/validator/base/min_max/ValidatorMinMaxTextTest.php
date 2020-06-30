<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\base\min_max;

use pvc\err\throwable\exception\pvc_exceptions\InvalidTypeException;
use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentException;
use pvc\msg\Msg;
use pvc\msg\UserMsg;
use pvc\validator\base\min_max\ValidatorMinMaxText;
use PHPUnit\Framework\TestCase;

class ValidatorMinMaxTextTest extends TestCase
{
    protected int $minLength;
    protected int $maxLength;
    protected ValidatorMinMaxText $validator;

    public function setUp(): void
    {
        $this->minLength = 5;
        $this->maxLength = 15;
        $this->validator = new ValidatorMinMaxText($this->minLength, $this->maxLength);
    }

    public function testSetMindException() : void
    {
        self::expectException(InvalidArgumentException::class);
        // min cannot be negative for text length
        $this->validator->setMin(-2);
    }

    public function testValidateBadArg() : void
    {
        $arg = 5;
        self::expectException(InvalidTypeException::class);
        /** @phpstan-ignore-next-line */
        $this->validator->validate($arg);
    }

    public function testValidateArgTooShort() : void
    {
        $arg = 'foo';
        self::assertFalse($this->validator->validate($arg));
        self::assertTrue($this->validator->getErrmsg() instanceof UserMsg);
    }

    public function testValidateArgTooLong() : void
    {
        $arg = 'superkalifragilistic';
        self::assertFalse($this->validator->validate($arg));
        self::assertTrue($this->validator->getErrmsg() instanceof UserMsg);
    }

    public function testValidateArgSuccess() : void
    {
        $arg = 'letters';
        self::assertTrue($this->validator->validate($arg));
    }
}
