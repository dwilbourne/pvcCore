<?php
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version 1.0
 */

namespace tests\helpers;

use pvc\helpers\DomEventHelper;
use PHPUnit\Framework\TestCase;

class DomEventHelperTest extends TestCase
{

    public function testIsEvent()
    {
        self::assertTrue(DomEventHelper::isEvent('dragenter'));
        self::assertTrue(DomEventHelper::isEvent('beforeunload'));
        self::assertFalse(DomEventHelper::isEvent('foo'));
    }
}
