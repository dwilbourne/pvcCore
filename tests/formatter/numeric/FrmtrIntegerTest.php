<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\formatter\numeric;

use pvc\err\throwable\exception\pvc_exceptions\InvalidTypeException;
use pvc\formatter\numeric\FrmtrInteger;
use PHPUnit\Framework\TestCase;

class FrmtrIntegerTest extends TestCase
{
    protected FrmtrInteger $frmtr;

    public function setUp(): void
    {
        $this->frmtr = new FrmtrInteger();
    }


    /**
     * @function testFormat
     * @param int $value
     * @param string $expectedValue
     * @throws InvalidTypeException
     * @dataProvider numberProvider
     *
     */
    public function testFormat(int $value, string $expectedValue) : void
    {
        self::assertEquals($expectedValue, $this->frmtr->format($value));
    }

    public function numberProvider() : array
    {
        return [
            'basic test' => [5, '5'],
            'includes grouping separator' => [1234, '1,234'],
            'negative number' => [-12345, '-12,345']
        ];
    }

    public function testBadArgument() : void
    {
        self::expectException(InvalidTypeException::class);
        $this->frmtr->format('foo');
    }
}
