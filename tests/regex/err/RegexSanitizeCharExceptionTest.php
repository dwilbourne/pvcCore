<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\regex\err;

use pvc\err\throwable\exception\pvc_exceptions\InvalidValueException;
use pvc\regex\err\RegexSanitizeCharException;
use \Throwable;
use PHPUnit\Framework\TestCase;

/**
 * Class RegexSanitizeCharExceptionTest
 */

class RegexSanitizeCharExceptionTest extends TestCase
{

    public function testConstruct() : void
    {

        $exception = new RegexSanitizeCharException('foo');

        static::assertTrue($exception instanceof Throwable);
        static::assertTrue($exception instanceof InvalidValueException);
    }
}
