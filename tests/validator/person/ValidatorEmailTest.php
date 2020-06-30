<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\person;

use pvc\validator\person\ValidatorEmail;
use PHPUnit\Framework\TestCase;

class ValidatorEmailTest extends TestCase
{
    protected ValidatorEmail $validator;

    public function setUp() : void
    {
        $this->validator = new ValidatorEmail();
    }

    /**
     * @function testValidate
     * @param string $input
     * @param bool $expectedResult
     * @dataProvider dataProvider
     */
    public function testValidate(string $input, bool $expectedResult) : void
    {
        self::assertEquals($expectedResult, $this->validator->validate($input));
    }

    public function dataProvider() : array
    {
        return [
            'basic email' => ['anyone@example.com', true],
            'test top level domain' => ['someone@example.foo', true],
            'test dotless domain name' => ['someone@example', false]
        ];
    }

    public function testValidateUnicodeAllowed() : void
    {
        $this->validator->allowUnicode();
        $letteraWithGraveAccent = json_decode('"' . '\u00E0' . '"');
        $emailAddr = "P" . $letteraWithGraveAccent . "le@unicode.com";
        self::assertTrue($this->validator->validate($emailAddr));
    }

    public function testValidateUnicodeNotAllowed() : void
    {
        $this->validator->allowUnicode(false);
        $letteraWithGraveAccent = json_decode('"' . '\u00E0' . '"');
        $emailAddr = "P" . $letteraWithGraveAccent . "le@unicode.com";
        self::assertFalse($this->validator->validate($emailAddr));
    }
}
