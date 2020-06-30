<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\formatter\date_time;

use Carbon\Carbon;
use Mockery;
use PHPUnit\Framework\TestCase;
use pvc\formatter\date_time\FrmtrTimeAbstract;
use pvc\intl\Locale;
use pvc\intl\TimeZone;
use pvc\intl\UtcOffset;
use pvc\time\Time;
use pvc\validator\base\data_type\ValidatorTypeCarbonDateTime;
use pvc\validator\base\data_type\ValidatorTypeTime;

class FrmtrTimeAbstractTest extends TestCase
{
    /** @phpstan-ignore-next-line */
    protected $frmtr;

    public function setUp(): void
    {
        $this->frmtr = Mockery::mock(FrmtrTimeAbstract::class)->makePartial();
    }

    public function testSetGetUtcOffset() : void
    {
        $utcOffset = Mockery::mock(UtcOffset::class);
        $this->frmtr->setUtcOffset($utcOffset);
        self::assertEquals($utcOffset, $this->frmtr->getUtcOffset());
    }

    public function testConstruct() : void
    {
        $locale = Mockery::mock(Locale::class);
        $utcOffset = Mockery::mock(UtcOffset::class);
        $this->frmtr->__construct($locale, $utcOffset);
        self::assertTrue($this->frmtr->getTypeValidator() instanceof ValidatorTypeTime);
        self::assertEquals($locale, $this->frmtr->getLocale());
        self::assertEquals($utcOffset, $this->frmtr->getUtcOffset());
    }

    public function testFormatValueImplicitly() : void
    {
        // 5:33 am GMT
        $time = new Time((5 * 60 * 60) + (33 * 60));
        $this->frmtr->shouldReceive('getPatternFromLocale')->withNoArgs()->andReturn('g:i a');

        $tv = Mockery::mock(ValidatorTypeTime::class);
        $tv->shouldReceive('validate')->withArgs([$time])->andReturn(true);
        $this->frmtr->shouldReceive('getTypeValidator')->withNoArgs()->andReturn($tv);

        // give this test a 1 hour positive offset from GMT
        $u = Mockery::mock(UtcOffset::class);
        $u->shouldReceive('getUtcOffsetSeconds')->withNoArgs()->andReturn(3600);
        $this->frmtr->shouldReceive('getUtcOffset')->withNoArgs()->andReturn($u);

        $expectedResult = '6:33 am';
        self::assertEquals($expectedResult, $this->frmtr->format($time));
    }
}
