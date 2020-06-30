<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\base\text\filter_var;

use pvc\validator\base\text\filter_var\ValidatorFilterVarUrl;
use PHPUnit\Framework\TestCase;

class ValidatorFilterVarUrlTest extends TestCase
{
    protected ValidatorFilterVarUrl $validator;

    public function setUp() : void
    {
        $this->validator = new ValidatorFilterVarUrl();
    }

    public function testSetGetPathRequired() : void
    {
        self::assertFalse($this->validator->isPathRequired());
        $this->validator->setPathRequired(true);
        self::assertTrue($this->validator->isPathRequired());
    }

    public function testSetGetQueryRequired() : void
    {
        self::assertFalse($this->validator->isQueryRequired());
        $this->validator->setQueryRequired(true);
        self::assertTrue($this->validator->isQueryRequired());
    }
}
