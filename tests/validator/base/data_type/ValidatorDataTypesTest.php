<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\base\data_type;

use Carbon\Carbon;
use Mockery;
use PHPUnit\Framework\TestCase;
use pvc\intl\TimeZone;
use pvc\msg\Msg;
use pvc\time\Time;
use pvc\validator\base\data_type\ValidatorTypeBoolean;
use pvc\validator\base\data_type\ValidatorTypeCarbonDateTime;
use pvc\validator\base\data_type\ValidatorTypeCarbonDate;
use pvc\validator\base\data_type\ValidatorTypeInteger;
use pvc\validator\base\data_type\ValidatorTypeMsg;
use pvc\validator\base\data_type\ValidatorTypeFloat;
use pvc\validator\base\data_type\ValidatorTypeTime;
use pvc\validator\base\data_type\ValidatorTypeTimeZone;

class ValidatorDataTypesTest extends TestCase
{
    public function testValidatorTypeBoolean(): void
    {
        $v = new ValidatorTypeBoolean();
        self::assertTrue($v->validate(true));
        self::assertTrue($v->validate(false));
        self::assertFalse($v->validate(0));
        self::assertFalse($v->validate(1));
        self::assertFalse($v->validate('foo'));
    }

    public function testValidatorTypeMsg(): void
    {
        $msg = Mockery::mock(Msg::class);
        $v = new ValidatorTypeMsg();
        self::assertFalse($v->validate(5));
        self::assertTrue($v->validate($msg));
    }

    public function testValidatorTypeCarbonDateTime(): void
    {
        $dt = Mockery::mock(Carbon::class);
        $v = new ValidatorTypeCarbonDateTime();
        self::assertFalse($v->validate(5));
        self::assertTrue($v->validate($dt));
    }

    public function testValidatorTypeCarbonDate(): void
    {
        $carbon = new Carbon('1985-05-20 13:12');
        $v = new ValidatorTypeCarbonDate();
        self::assertFalse($v->validate($carbon));

        $carbon->setTime(0, 0, 0, 0);
        self::assertTrue($v->validate($carbon));
    }

    public function testValidatorTypeFloat(): void
    {
        $v = new ValidatorTypeFloat();
        self::assertFalse($v->validate(5));
        self::assertTrue($v->validate(5.0));
        self::assertFalse($v->validate('foobar'));
        self::assertTrue($v->validate(1.23));
    }

    public function testValidatorTypeInteger(): void
    {
        $v = new ValidatorTypeInteger();
        self::assertTrue($v->validate(5));
        self::assertFalse($v->validate(5.0));
        self::assertFalse($v->validate('foobar'));
    }

    public function testValidatorTypeTime(): void
    {
        $v = new ValidatorTypeTime();

        $t = new Time(322);
        self::assertTrue($v->validate($t));

        self::assertFalse($v->validate('foo'));
    }

    public function testValidatorTypeTimezone() : void
    {
        $v = new ValidatorTypeTimeZone();
        $tz = new TimeZone('America/New_York');
        self::assertTrue($v->validate($tz));
        self::assertFalse($v->validate('foo'));
    }
}
