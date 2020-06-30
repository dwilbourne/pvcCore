<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\base\text\filter_var;

use pvc\validator\base\text\filter_var\ValidatorFilterVarEmail;
use PHPUnit\Framework\TestCase;

class ValidatorFilterVarEmailTest extends TestCase
{
    protected ValidatorFilterVarEmail $validator;

    public function setUp() : void
    {
        $this->validator = new ValidatorFilterVarEmail();
    }

    public function testConstruct() : void
    {
        self::assertEquals(FILTER_VALIDATE_EMAIL, $this->validator->getFilter());
    }

    public function testSetGetUnicodeAllowed() : void
    {
        self::assertTrue($this->validator->isUnicodeAllowed());
        $this->validator->allowUnicode(false);
        self::assertFalse($this->validator->isUnicodeAllowed());
    }
}
