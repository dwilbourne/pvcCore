<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\intl;

use PHPUnit\Framework\TestCase;
use pvc\intl\IsoCountryCodes;

class CountryCodesTest extends TestCase
{

    public function testValidateCode() : void
    {
        static::assertTrue(IsoCountryCodes::validateCountryCode('US'));
    }

    public function testGetCountryCodes() : void
    {
        static::assertTrue(0 < count(IsoCountryCodes::getCountryCodes()));
    }

    public function testGetCountryCodeFromCountry() : void
    {
        static::assertEquals('US', IsoCountryCodes::getCountryCodeFromCountry('United States'));
    }
}
