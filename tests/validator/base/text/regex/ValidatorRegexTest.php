<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\base\text\regex;

use Mockery;
use pvc\err\throwable\exception\pvc_exceptions\UnsetAttributeException;
use pvc\regex\Regex;
use pvc\validator\base\text\regex\ValidatorRegex;
use PHPUnit\Framework\TestCase;

class ValidatorRegexTest extends TestCase
{
    /** @phpstan-ignore-next-line */
    protected $validator;

    public function setUp() : void
    {
        $this->validator = Mockery::mock(ValidatorRegex::class)->makePartial();
    }

    public function testSetGetRegex() : void
    {
        $regex = Mockery::mock(Regex::class);
        $regex->shouldReceive('getPattern')->withNoArgs()->andReturn('some non-empty string');
        $this->validator->setRegex($regex);
        self::assertEquals($regex, $this->validator->getRegex());
    }

    public function testSetRegexException() : void
    {
        $regex = Mockery::mock(Regex::class);
        $regex->shouldReceive('getPattern')->withNoArgs()->andReturn(null);
        self::expectException(UnsetAttributeException::class);
        $this->validator->setRegex($regex);
    }
}
