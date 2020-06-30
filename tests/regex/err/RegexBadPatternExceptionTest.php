<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\regex\err;

use PHPUnit\Framework\TestCase;
use pvc\err\throwable\exception\pvc_exceptions\InvalidValueException;
use pvc\regex\err\RegexBadPatternException;
use Throwable;

/**
 * Class RegexBadPatternExceptionTest
 */
class RegexBadPatternExceptionTest extends TestCase
{

    public function testConstruct() : void
    {
        $exception = new RegexBadPatternException();
        static::assertTrue($exception instanceof Throwable);
        static::assertTrue($exception instanceof InvalidValueException);
    }
}
