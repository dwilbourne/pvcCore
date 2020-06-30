<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\numeric;

use pvc\validator\numeric\ValidatorInteger;
use PHPUnit\Framework\TestCase;
use pvc\validator\numeric\ValidatorIntegerNegative;
use pvc\validator\numeric\ValidatorIntegerNonNegative;
use pvc\validator\numeric\ValidatorIntegerPositive;

class ValidatorIntegerTest extends TestCase
{

    /**
     * @function testValidate
     * @param mixed $input
     * @param bool $expectedResult
     * @dataProvider dataProvider
     */
    public function testValidate($input, bool $expectedResult) : void
    {
        $validator = new ValidatorInteger(-20, -4);
        self::assertEquals($expectedResult, $validator->validate($input));
    }

    public function dataProvider() : array
    {
        return [
            'basic test with string input' => ['foo', false],
            'basic test with boolean input' => [true, false],
            'basic test with null input' => [null, false],
            'test with float input' => [-5.72, false],
            'test with integer input containing decimal point' => [-5.0, false],
            'test with any old int too large' => [1234, false],
            'test with any old int too small' => [-30, false],
            'test with any old int just right' => [-10, true]
        ];
    }

    /**
     * @function testValidateNegative
     * @param int $input
     * @param bool $expectedResult
     * @dataProvider dataProviderNegative
     */
    public function testValidatorIntegerNegative(int $input, bool $expectedResult) : void
    {
        $validator = new ValidatorIntegerNegative();
        self::assertEquals($expectedResult, $validator->validate($input));
    }

    public function dataProviderNegative() : array
    {
        return [
            'input = 5' => [5, false],
            'input = 0' => [0, false],
            'input = -5' => [-5, true]
        ];
    }

    /**
     * @function testValidatorIntegerNonNegative
     * @param int $input
     * @param bool $expectedResult
     * @dataProvider dataProviderNonNegative
     */
    public function testValidatorIntegerNonNegative(int $input, bool $expectedResult) : void
    {
        $validator = new ValidatorIntegerNonNegative();
        self::assertEquals($expectedResult, $validator->validate($input));
    }

    public function dataProviderNonNegative() : array
    {
        return [
            'input = 5' => [5, true],
            'input = 0' => [0, true],
            'input = -5' => [-5, false]
        ];
    }

    /**
     * @function testValidatorIntegerPositive
     * @param int $input
     * @param bool $expectedResult
     * @dataProvider dataProviderPositive
     */
    public function testValidatorIntegerPositive(int $input, bool $expectedResult) : void
    {
        $validator = new ValidatorIntegerPositive();
        self::assertEquals($expectedResult, $validator->validate($input));
    }

    public function dataProviderPositive() : array
    {
        return [
            'input = 5' => [5, true],
            'input = 0' => [0, false],
            'input = -5' => [-5, false]
        ];
    }
}
