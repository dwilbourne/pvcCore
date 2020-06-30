<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\base\min_max;

use pvc\err\throwable\exception\pvc_exceptions\InvalidTypeException;
use pvc\msg\Msg;
use pvc\validator\base\min_max\ValidatorMinMaxFloat;
use PHPUnit\Framework\TestCase;

class ValidatorMinMaxFloatTest extends TestCase
{
    protected ValidatorMinMaxFloat $validator;

    public function setUp() : void
    {
        $min = 17.22;
        $max = 47.9554;

        $this->validator = new ValidatorMinMaxFloat($min, $max);
    }

    /**
     * @function testCompareValues
     * @param float $a
     * @param float $b
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
            [5.5, 6.7, -1],
            [6.99, .15, 1],
            [5.00, 5.0, 0],
        ];
    }

    public function testValidatorMinMaxFloatFailureTypeArgIsString() : void
    {
        $input = '2019-12-02';
        self::expectException(InvalidTypeException::class);
        self::assertFalse($this->validator->validate($input));
    }

    public function testValidatorMinMaxFloatFailureValue() : void
    {
        $input = 133.968;
        self::assertFalse($this->validator->validate($input));
        self::assertTrue($this->validator->getErrmsg() instanceof Msg);
    }

    public function testValidatorMinMaxFloatSuccess() : void
    {
        $input = 30.534;
        self::assertTrue($this->validator->validate($input));
    }
}
