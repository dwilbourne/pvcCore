<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\person;

use pvc\testingTraits\RandomStringGeneratorTrait;
use pvc\validator\person\ValidatorPersonName;
use PHPUnit\Framework\TestCase;

class ValidatorPersonNameTest extends TestCase
{
    use RandomStringGeneratorTrait;

    protected ValidatorPersonName $validator;

    public function setUp() : void
    {
        $this->validator = new ValidatorPersonName();
    }

    public function testLengths() : void
    {
        // single letter is not a name
        $string = 'f';
        self::assertFalse($this->validator->validate($string));
        // more than 100 characters is not allowed
        $string = $this->randomString(101);
        self::assertFalse($this->validator->validate($string));
        // something between the two is fine
        $string = $this->randomString(15);
        self::assertTrue($this->validator->validate($string));
    }
}
