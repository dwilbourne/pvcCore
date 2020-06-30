<?php

namespace tests\validator\document\xml\schema;

use pvc\validator\document\xml\schema\Schema;

class SchemaTest extends TestCase
{
    public function testCreateObjectAndReadProperties() : void
    {
        $schema = new Schema('a', 'b');
        static::assertSame('a', $schema->getNamespace(), 'First parameter is namespace');
        static::assertSame('b', $schema->getLocation(), 'Second parameter is location');
    }
}
