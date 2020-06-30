<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\numeric;

use pvc\validator\numeric\ValidatorFloat;
use PHPUnit\Framework\TestCase;

class ValidatorFloatTest extends TestCase
{
    protected ValidatorFloat $validator;

    public function setUp() : void
    {
        $this->validator = new ValidatorFloat(-10.5, -4.765);
    }

    /**
     * @function testValidate
     * @param mixed $input
     * @param bool $expectedResult
     * @dataProvider dataProvider
     */
    public function testValidate($input, bool $expectedResult) : void
    {
        self::assertEquals($expectedResult, $this->validator->validate($input));
    }

    public function dataProvider() : array
    {
        return [
            'basic test with string input' => ['foo', false],
            'basic test with boolean input' => [true, false],
            'basic test with null input' => [null, false],
            'test with integer input' => [-5, false],
            'test with integer input containing decimal point' => [-5.0, true],
            'test with any old float too large' => [1234.6, false],
            'test with any old float too small' => [-15.456, false],
            'test with any old float just right' => [-8.2, true]
        ];
    }
}
