<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\charset;

use pvc\charset\Charset;
use PHPUnit\Framework\TestCase;
use pvc\charset\InvalidCharsetException;

class CharsetTest extends TestCase
{
    public function testSetCharsetException() : void
    {
        self::expectException(InvalidCharsetException::class);
        $cs = new Charset(65502);
    }

    public function testSetGetCharsetConstant() : void
    {
        $constant = Charset::UTF_8;
        $cs = new Charset($constant);
        self::assertEquals($constant, $cs->getCharsetConstant());
    }

    public function testSetGetCharsetStringAndGetValidCharsets() : void
    {
        $constant = Charset::UTF_8;
        $cs = new Charset($constant);
        $vcs = $cs->getValidCharsets();
        self::assertEquals($cs->getCharsetString(), $vcs[$constant]);
        self::assertEquals('UTF-8', $cs->getCharsetString());
    }

    public function testCharsetParseString() : void
    {
        $cs = new Charset();
        self::assertFalse($cs->parseCharsetString('foo'));
        self::assertTrue($cs->parseCharsetString('utf-8'));
        self::assertEquals(Charset::UTF_8, $cs->getCharsetConstant());
    }
}
