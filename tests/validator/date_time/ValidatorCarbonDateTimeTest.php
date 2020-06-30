<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\date_time;

use Carbon\Carbon;
use pvc\msg\MsgInterface;
use pvc\validator\date_time\ValidatorCarbonDateTime;
use PHPUnit\Framework\TestCase;

class ValidatorCarbonDateTimeTest extends TestCase
{
    protected ValidatorCarbonDateTime $validator;

    public function setUp() : void
    {
        $this->validator = new ValidatorCarbonDateTime();
    }

    public function testConstruct() : void
    {
        $carbon = Carbon::createFromTimestamp(ValidatorCarbonDateTime::MIN_DATE_TIME);
        self::assertEquals($carbon, $this->validator->getMin());
        $carbon = Carbon::createFromTimestamp(ValidatorCarbonDateTime::MAX_DATE_TIME);
        self::assertEquals($carbon, $this->validator->getMax());
        self::assertTrue($this->validator->isRequired());
    }

    public function testSetGetMin() : void
    {
        $min = Carbon::createFromFormat('Y-m-d', '2000-01-01');
        $this->validator->setMin($min);
        self::assertEquals($min, $this->validator->getMin());
    }

    public function testSetGetMax() : void
    {
        $max = Carbon::createFromFormat('Y-m-d', '2000-01-01');
        $this->validator->setMax($max);
        self::assertEquals($max, $this->validator->getMax());
    }

    /** @phpstan-ignore-next-line */
    public function testValidate()
    {
        $input = Carbon::createFromFormat('Y-m-d', '2000-01-01');
        self::assertTrue($this->validator->validate($input));
        self::assertFalse($this->validator->validate(null));
        $this->validator->setMax($input);
        $newInput = Carbon::createFromFormat('Y-m-d', '2010-01-01');
        self::assertFalse($this->validator->validate($newInput));
        return $this->validator;
    }

    /**
     * @function testGetErrmsg
     * @depends testValidate
     * @param ValidatorCarbonDateTime $validator
     */
    public function testGetErrmsg(ValidatorCarbonDateTime $validator) : void
    {
        self::assertTrue($validator->getErrMsg() instanceof MsgInterface);
    }
}
