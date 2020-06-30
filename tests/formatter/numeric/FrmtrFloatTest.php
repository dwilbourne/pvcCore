<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\formatter\numeric;

use pvc\err\throwable\exception\pvc_exceptions\InvalidTypeException;
use pvc\err\throwable\exception\pvc_exceptions\InvalidValueException;
use pvc\formatter\numeric\FrmtrFloat;
use PHPUnit\Framework\TestCase;

class FrmtrFloatTest extends TestCase
{
    protected FrmtrFloat $frmtr;

    public function setUp(): void
    {
        $this->frmtr = new FrmtrFloat();
    }

    /**
     * @function testFormat
     * @param float $value
     * @param string $expectedValue
     * @throws InvalidTypeException
     * @dataProvider numberProvider
     */
    public function testFormat(float $value, string $expectedValue) : void
    {
        self::assertEquals($expectedValue, $this->frmtr->format($value));
    }

    public function numberProvider() : array
    {
        return [
            'basic test with integer' => [5, '5'],
            'basic test with float' => [5.00, '5'],
            'includes grouping separator and rounds' => [1234.4567, '1,234.457'],
            'negative number and rounds' => [-12345.994321, '-12,345.994']
        ];
    }

    public function testSetGetDecimalPlaces() : void
    {
        // default decimal places is 0
        self::assertEquals(0, $this->frmtr->getDecimalPlaces());
        $this->frmtr->setDecimalPlaces(4);
        self::assertEquals(4, $this->frmtr->getDecimalPlaces());
    }

    public function testSetDecimalPlacesException() : void
    {
        self::expectException(InvalidValueException::class);
        $this->frmtr->setDecimalPlaces(-2);
    }

    public function testBadArgument() : void
    {
        self::expectException(InvalidTypeException::class);
        $this->frmtr->format('foo');
    }
}
