<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\intl;

use PHPUnit\Framework\TestCase;
use pvc\intl\err\InvalidLocaleException;
use pvc\intl\Locale;

class LocaleTest extends TestCase
{

    protected Locale $locale;

    public function setUp(): void
    {
        $this->locale = new Locale();
    }

    public function testSetGetLocale() : void
    {
        $localeString = 'fr_FR';
        $this->locale->setLocale($localeString);
        self::assertEquals($localeString, $this->locale->getLocale());
    }

    public function testSetLocaleException() : void
    {
        $localeString = 'foo_Bar';
        $this->expectException(InvalidLocaleException::class);
        $this->locale->setLocale($localeString);
    }

    public function testDefaultLocale() : void
    {
        $dfltLocale = \Locale::getDefault();
        self::assertEquals($dfltLocale, $this->locale->getLocale());
    }

    public function testGetLanguage() : void
    {
        $localeString = 'fr_FR';
        $this->locale->setLocale($localeString);
        self::assertEquals('fr', $this->locale->getLanguage());
    }
}
