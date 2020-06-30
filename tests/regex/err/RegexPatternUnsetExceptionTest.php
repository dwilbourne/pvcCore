<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\regex\err;

use pvc\err\throwable\exception\pvc_exceptions\UnsetAttributeException;
use pvc\regex\err\RegexPatternUnsetException;
use \Throwable;
use PHPUnit\Framework\TestCase;

/**
 * Class RegexMatchesUnsetExceptionTest
 */

class RegexPatternUnsetExceptionTest extends TestCase
{

    public function testConstruct() : void
    {

        $exception = new RegexPatternUnsetException();

        static::assertTrue($exception instanceof Throwable);
        static::assertTrue($exception instanceof UnsetAttributeException);
    }
}
