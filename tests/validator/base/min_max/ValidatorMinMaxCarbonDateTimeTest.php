<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\base\min_max;

use Carbon\Carbon;
use DateTime;
use pvc\err\throwable\exception\pvc_exceptions\InvalidTypeException;
use pvc\msg\Msg;
use PHPUnit\Framework\TestCase;
use pvc\validator\base\min_max\ValidatorMinMaxCarbonDateTime;

class ValidatorMinMaxCarbonDateTimeTest extends TestCase
{
    protected ValidatorMinMaxCarbonDateTime $validator;

    public function setUp() : void
    {
        $min = new Carbon('2013-07-05 20:22');
        $max = new Carbon('2015-12-31 4:17:16');
        $this->validator = new ValidatorMinMaxCarbonDateTime($min, $max);
    }

    /**
     * @function testCompareValues
     * @param Carbon $a
     * @param Carbon $b
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
            [Carbon::today(), Carbon::yesterday(), 1],
            [Carbon::yesterday(), Carbon::today(), -1],
            [Carbon::today(), Carbon::today(), 0],
        ];
    }

    public function testValidatorMinMaxDateFailureTypeArgIsDateTimeObject() : void
    {
        $input = new DateTime('2019-12-02');
        self::expectException(InvalidTypeException::class);
        self::assertFalse($this->validator->validate($input));
    }

    public function testValidatorMinMaxDateFailureValue() : void
    {
        $input = new Carbon('2019-12-02');
        self::assertFalse($this->validator->validate($input));
        self::assertTrue($this->validator->getErrmsg() instanceof Msg);
    }

    public function testValidatorMinMaxDateSuccess() : void
    {
        $input = new Carbon('2014-03-22');
        self::assertTrue($this->validator->validate($input));
    }
}
