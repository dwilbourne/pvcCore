<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\base\min_max;

use pvc\err\throwable\exception\pvc_exceptions\InvalidTypeException;
use pvc\msg\Msg;
use pvc\validator\base\min_max\ValidatorMinMaxInteger;
use PHPUnit\Framework\TestCase;

class ValidatorMinMaxIntegerTest extends TestCase
{
    protected ValidatorMinMaxInteger $validator;

    public function setUp() : void
    {
        $min = 17;
        $max = 47;
        $this->validator = new ValidatorMinMaxInteger($min, $max);
    }

    /**
     * @function testCompareValues
     * @param int $a
     * @param int $b
     * @param int $expectedResult
     * @dataProvider dataProvider
     */
    public function testCompareValues($a, $b, int $expectedResult) : void
    {
        self::assertEquals($expectedResult, $this->validator->compareValues($a, $b));
    }

    public function dataProvider() : array
    {
        return [
            [5, 6, -1],
            [6, 5, 1],
            [5, 5, 0],
        ];
    }

    public function testValidatorMinMaxIntegerFailureTypeArgIsString() : void
    {
        $input = 'foobar!';
        self::expectException(InvalidTypeException::class);
        self::assertFalse($this->validator->validate($input));
    }

    public function testValidatorMinMaxIntegerFailureValue() : void
    {
        $input = 133;
        self::assertFalse($this->validator->validate($input));
        self::assertTrue($this->validator->getErrmsg() instanceof Msg);
    }

    public function testValidatorMinMaxIntegerSuccess() : void
    {
        $input = 30;
        self::assertTrue($this->validator->validate($input));
    }
}
