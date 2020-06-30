<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\intl;

use PHPUnit\Framework\TestCase;
use pvc\intl\IsoLanguageCodes;

class LanguageCodesTest extends TestCase
{

    public function testValidateCode() : void
    {
        static::assertTrue(IsoLanguageCodes::validateLanguageCode('en'));
    }

    public function testGetLanguageCodes() : void
    {
        static::assertTrue(0 < count(IsoLanguageCodes::getLanguageCodes()));
    }

    public function testGetLanguageCodeFromLanguage() : void
    {
        static::assertEquals('en', IsoLanguageCodes::getLanguageCodeFromLanguage('English'));
    }
}
