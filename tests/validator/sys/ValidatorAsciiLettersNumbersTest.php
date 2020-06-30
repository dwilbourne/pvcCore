<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\sys;

use pvc\validator\sys\ValidatorAsciiLettersNumbers;
use PHPUnit\Framework\TestCase;

class ValidatorAsciiLettersNumbersTest extends TestCase
{
    protected ValidatorAsciiLettersNumbers $validator;

    public function setUp() : void
    {
        $this->validator = new ValidatorAsciiLettersNumbers(1, 10);
    }

    public function testNull() : void
    {
        self::assertFalse($this->validator->validate(null));
        $this->validator->setRequired(false);
        self::assertTrue($this->validator->validate(null));
    }

    public function testType() : void
    {
        self::assertFalse($this->validator->validate(9));
        self::assertTrue($this->validator->validate('sometext'));
    }

    public function testLengths() : void
    {
        self::assertFalse($this->validator->validate(''));
        self::assertFalse($this->validator->validate('This text is too long for the validator'));
        self::assertTrue($this->validator->validate('justthis'));
    }

    public function testChars() : void
    {
        self::assertFalse($this->validator->validate('^&*)'));
    }
}
