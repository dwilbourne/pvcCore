<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\formatter\numeric;

use pvc\err\throwable\exception\pvc_exceptions\InvalidTypeException;
use pvc\formatter\numeric\FrmtrCurrency;
use PHPUnit\Framework\TestCase;

class FrmtrCurrencyTest extends TestCase
{
    protected FrmtrCurrency $frmtr;

    public function setUp() : void
    {
        $this->frmtr = new FrmtrCurrency();
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

    /**
     * @function numberProvider
     * @return array
     *
     * This test data is specific to the locale for the United States
     */
    public function numberProvider()
    {
        return [
            'basic test with integer' => [5, '$5.00'],
            'basic test with float' => [5.00, '$5.00'],
            'includes grouping separator and rounds' => [1234.4567, '$1,234.46'],
            'negative number and rounds' => [-12345.994321, '-$12,345.99']
        ];
    }
}
