<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\regex\err;

use pvc\err\throwable\exception\pvc_exceptions\InvalidArrayIndexException;
use pvc\regex\err\RegexInvalidMatchIndexException;
use \Throwable;
use PHPUnit\Framework\TestCase;

/**
 * Class RegexInvalidMatchIndexExceptionTest
 */

class RegexInvalidMatchIndexExceptionTest extends TestCase
{

    public function testConstruct() : void
    {

        $index = 'foo';
        $exception = new RegexInvalidMatchIndexException($index);

        static::assertTrue($exception instanceof Throwable);
        static::assertTrue($exception instanceof InvalidArrayIndexException);
    }
}
