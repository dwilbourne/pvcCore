<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\base\text\filter_var;

use Mockery;
use pvc\validator\base\text\filter_var\ValidatorFilterVar;
use PHPUnit\Framework\TestCase;

class ValidatorFilterVarTest extends TestCase
{
    /** @phpstan-ignore-next-line */
    protected $validator;

    protected int $filter;
    protected array $options;

    public function setUp() : void
    {
        $this->validator = Mockery::mock(ValidatorFilterVar::class)->makePartial();
        $this->filter = FILTER_VALIDATE_URL;
        $this->options = ['options' => ['flags' => FILTER_FLAG_PATH_REQUIRED]];
    }

    public function testSetGetFilter() : void
    {
        $this->validator->setFilter($this->filter);
        self::assertEquals($this->filter, $this->validator->getFilter());
    }

    // the rest of the class is tested when the child classes are tested.
}
