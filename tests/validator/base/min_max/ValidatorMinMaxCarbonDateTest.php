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
use pvc\validator\base\min_max\ValidatorMinMaxCarbonDate;
use PHPUnit\Framework\TestCase;

class ValidatorMinMaxCarbonDateTest extends TestCase
{
    protected ValidatorMinMaxCarbonDate $validatorMinMaxDate;

    public function setUp() : void
    {
        $min = new Carbon('2013-07-05');
        $max = new Carbon('2015-12-31');
        $this->validatorMinMaxDate = new ValidatorMinMaxCarbonDate($min, $max);
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
        self::assertEquals($expectedResult, $this->validatorMinMaxDate->compareValues($a, $b));
    }

    public function dataProvider() : array
    {
        return [
            [Carbon::today(), Carbon::yesterday(), 1],
            [Carbon::yesterday(), Carbon::today(), -1],
            [Carbon::today(), Carbon::today(), 0],
        ];
    }


    public function testValidatorMinMaxDateFailureTypeArgHasSeconds() : void
    {
        $input = new Carbon('2019-12-02 14:05');
        self::expectException(InvalidTypeException::class);
        self::assertFalse($this->validatorMinMaxDate->validate($input));
    }

    public function testValidatorMinMaxDateFailureTypeArgIsDateTimeObject() : void
    {
        $input = new DateTime('2019-12-02');
        self::expectException(InvalidTypeException::class);
        self::assertFalse($this->validatorMinMaxDate->validate($input));
    }

    public function testValidatorMinMaxDateFailureValue() : void
    {
        $input = new Carbon('2019-12-02');
        self::assertFalse($this->validatorMinMaxDate->validate($input));
        self::assertTrue($this->validatorMinMaxDate->getErrmsg() instanceof Msg);
    }

    public function testValidatorMinMaxDateSuccess() : void
    {
        $input = new Carbon('2014-03-22');
        self::assertTrue($this->validatorMinMaxDate->validate($input));
    }
}
