<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\formatter\date_time;

use Mockery;
use pvc\formatter\date_time\FrmtrDateTimeAbstract;
use PHPUnit\Framework\TestCase;
use pvc\intl\Locale;

class FrmtrDateTimeAbstractTest extends TestCase
{
    /** @phpstan-ignore-next-line */
    protected $frmtr;

    public function setUp(): void
    {
        $this->frmtr = Mockery::mock(FrmtrDateTimeAbstract::class)->makePartial();
    }

    public function testSetGetLocale() : void
    {
        $locale = new locale('de_DE');
        $this->frmtr->setLocale($locale);
        self::assertEquals($locale, $this->frmtr->getLocale());
    }

    public function testSetGetDefaultLocale() : void
    {
        $this->frmtr->setLocale();
        self::assertTrue($this->frmtr->getLocale() instanceof Locale);
    }
}
