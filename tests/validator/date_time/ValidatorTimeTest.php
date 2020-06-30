<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\date_time;

use pvc\msg\MsgInterface;
use pvc\time\Time;
use pvc\validator\date_time\ValidatorTime;
use PHPUnit\Framework\TestCase;

class ValidatorTimeTest extends TestCase
{
    protected ValidatorTime $validator;

    public function setUp() : void
    {
        $this->validator = new ValidatorTime();
    }

    public function testConstruct() : void
    {
        self::assertEquals(Time::MIN_TIME, $this->validator->getMin()->getTimestamp());
        self::assertEquals(Time::MAX_TIME, $this->validator->getMax()->getTimestamp());
        self::assertTrue($this->validator->isRequired());
    }

    public function testSetGetMin() : void
    {
        $min = new Time(12345);
        $this->validator->setMin($min);
        self::assertEquals($min, $this->validator->getMin());
    }

    public function testSetGetMax() : void
    {
        $max = new Time(54321);
        $this->validator->setMax($max);
        self::assertEquals($max, $this->validator->getMax());
    }

    public function testGetErrmsg() : void
    {
        $min = new Time(12345);
        $this->validator->setMin($min);
        $max = new Time(54321);
        $this->validator->setMax($max);
        self::assertFalse($this->validator->validate(1234));
        self::assertTrue($this->validator->getErrMsg() instanceof MsgInterface);
    }
}
