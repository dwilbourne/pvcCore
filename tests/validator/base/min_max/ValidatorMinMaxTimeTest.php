<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\base\min_max;

use pvc\err\throwable\exception\pvc_exceptions\InvalidTypeException;
use pvc\msg\Msg;
use pvc\time\Time;
use pvc\validator\base\min_max\ValidatorMinMaxTime;
use PHPUnit\Framework\TestCase;

class ValidatorMinMaxTimeTest extends TestCase
{
    protected ValidatorMinMaxTime $validator;

    public function setUp() : void
    {
        $min = new Time(30);
        $max = new Time(12055);
        $this->validator = new ValidatorMinMaxTime($min, $max);
    }

    /**
     * @function testCompareValues
     * @param Time $a
     * @param Time $b
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
            [new Time(5), new Time(6), -1],
            [new Time(6), new Time(5), 1],
            [new Time(5), new Time(5), 0],
        ];
    }

    public function testValidatorMinMaxTimeFailureTypeArgIsString() : void
    {
        $input = 'foobar!';
        self::expectException(InvalidTypeException::class);
        self::assertFalse($this->validator->validate($input));
    }

    public function testValidatorMinMaxTimeFailureValue() : void
    {
        $input = new Time(20239);
        self::assertFalse($this->validator->validate($input));
        self::assertTrue($this->validator->getErrmsg() instanceof Msg);
    }

    public function testValidatorMinMaxIntegerSuccess() : void
    {
        $input = new Time(8096);
        self::assertTrue($this->validator->validate($input));
    }
}
