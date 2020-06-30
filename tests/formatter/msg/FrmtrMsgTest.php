<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\formatter\msg;

use Mockery;
use pvc\formatter\msg\FrmtrMsg;
use PHPUnit\Framework\TestCase;
use pvc\validator\base\data_type\ValidatorType;

class FrmtrMsgTest extends TestCase
{
    /** @phpstan-ignore-next-line */
    protected $msgFrmtr;

    public function setUp(): void
    {
        $this->msgFrmtr = Mockery::mock(FrmtrMsg::class)->makePartial();
    }

    public function testConstruct() : void
    {
        $this->msgFrmtr->__construct();
        self::assertTrue($this->msgFrmtr->getTypeValidator() instanceof ValidatorType);
    }
}
