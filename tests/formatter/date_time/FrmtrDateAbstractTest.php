<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\formatter\date_time;

use Carbon\Carbon;
use Mockery;
use pvc\formatter\date_time\FrmtrDateAbstract;
use PHPUnit\Framework\TestCase;
use pvc\intl\Locale;
use pvc\intl\TimeZone;
use pvc\validator\base\data_type\ValidatorTypeCarbonDateTime;

class FrmtrDateAbstractTest extends TestCase
{
    /** @phpstan-ignore-next-line */
    protected $frmtr;

    public function setUp(): void
    {
        $this->frmtr = Mockery::mock(FrmtrDateAbstract::class)->makePartial();
    }

    public function testSetGetTz() : void
    {
        $tz = Mockery::mock(TimeZone::class);
        $this->frmtr->setTimeZone($tz);
        self::assertEquals($tz, $this->frmtr->getTimeZone());
    }

    public function testConstruct() : void
    {
        $locale = Mockery::mock(Locale::class);
        $tz = Mockery::mock(TimeZone::class);
        $this->frmtr->__construct($locale, $tz);
        self::assertTrue($this->frmtr->getTypeValidator() instanceof ValidatorTypeCarbonDateTime);
        self::assertEquals($locale, $this->frmtr->getLocale());
        self::assertEquals($tz, $this->frmtr->getTimezone());
    }

    public function testFormatValueImplicitly() : void
    {
        $carbon = new Carbon('2015-08-13');
        $this->frmtr->shouldReceive('getPatternFromLocale')->withNoArgs()->andReturn('d/m/Y');
        $tv = Mockery::mock(ValidatorTypeCarbonDateTime::class);
        $tv->shouldReceive('validate')->withArgs([$carbon])->andReturn(true);
        $this->frmtr->shouldReceive('getTypeValidator')->withNoArgs()->andReturn($tv);
        $expectedResult = '13/08/2015';
        self::assertEquals($expectedResult, $this->frmtr->format($carbon));
    }
}
