<?php

namespace tests\validator\document\xml\schema;

use Countable;
use InvalidArgumentException;
use IteratorAggregate;
use pvc\validator\document\xml\schema\Schema;
use pvc\validator\document\xml\schema\Schemas;

class SchemasTest extends TestCase
{
    public function testEmptyObject() : void
    {
        $schemas = new Schemas();
        static::assertInstanceOf(Countable::class, $schemas, 'The class must implements Countable');
        static::assertInstanceOf(IteratorAggregate::class, $schemas, 'The class must implements IteratorAggregate');
        static::assertCount(0, $schemas, 'Assert that the count is zero');
        static::assertSame([], $schemas->all(), 'Assert that the returned array is empty');
    }

    public function testCreateAndGetItem() : void
    {
        $ns = 'http://example.com';
        $location = 'http://example.com/xsd';
        $schemas = new Schemas();
        $schema = $schemas->create($ns, $location);
        static::assertCount(1, $schemas);
        static::assertInstanceOf(Schema::class, $schema, 'The create method must return a Schema object');
        static::assertSame($ns, $schema->getNamespace(), 'The object contains the right namespace');
        static::assertSame($location, $schema->getLocation(), 'The object contains the right location');
        static::assertSame($schema, $schemas->item($ns), 'The object created is the SAME as the object retrieved');
    }

    public function testItemNonExistent() : void
    {
        $ns = 'http://example.com';
        $schemas = new Schemas();
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Namespace $ns does not exists in the schemas");
        $schemas->item($ns);
    }

    public function testInsert() : void
    {
        $ns = 'http://example.com';
        $location = 'http://example.com/xsd';
        $schemas = new Schemas();
        $schema = $schemas->insert(new Schema($ns, $location));
        static::assertInstanceOf(Schema::class, $schema, 'The insert method must return a Schema object');
        static::assertCount(1, $schemas);
    }

    /**
     * @param int $count
     * @param string $ns
     * @param string $location
     * @return Schemas
     */
    public function createSchemaWithCount($count, $ns, $location)
    {
        $schemas = new Schemas();
        for ($i = 0; $i < $count; $i++) {
            $schemas->create($ns . $i, $location . $i);
        }
        return $schemas;
    }

    public function testInsertSeveral() : void
    {
        $ns = 'http://example.com/';
        $location = 'http://example.com/xsd/';
        $schemas = $this->createSchemaWithCount(5, $ns, $location);
        static::assertCount(5, $schemas, '5 namespaces where included');
        $schemas->create("{$ns}1", "{$location}X");
        static::assertCount(5, $schemas, '5 repeated schemas do not increment schemas count');
        static::assertSame("{$location}X", $schemas->item("{$ns}1")->getLocation(), 'The old schema was overriten');
    }

    public function testRemove() : void
    {
        $ns = 'http://example.com/';
        $location = 'http://example.com/xsd/';
        $schemas = $this->createSchemaWithCount(7, $ns, $location);
        $schemas->remove("{$ns}2");
        static::assertFalse($schemas->exists("{$ns}2"), 'Removed namespace 2 must not exists');
        $schemas->remove("{$ns}3");
        static::assertFalse($schemas->exists("{$ns}3"), 'Removed namespace 3 must not exists');
        static::assertCount(5, $schemas, 'After remove 2 items the count is 5');
        $schemas->remove("{$ns}2");
        static::assertCount(5, $schemas, 'Remove a non existent schema do nothing');
    }

    public function testGetImporterXsdEmpty() : void
    {
        $basefile = static::filesystemFixtureLocation('include-template.xsd');
        static::assertFileExists($basefile, "File $basefile must exist");
        $schemas = new Schemas();
        static::assertXmlStringEqualsXmlFile($basefile, $schemas->getImporterXsd());
    }

    public function testGetImporterXsdWithContents() : void
    {
        $basefile = static::filesystemFixtureLocation('include-realurls.xsd');
        static::assertFileExists($basefile, "File $basefile must exists");

        $schemas = new Schemas();
        $schemas->create(
            'http://www.sat.gob.mx/cfd/3',
            'http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv32.xsd'
        );
        $schemas->create(
            'http://www.sat.gob.mx/TimbreFiscalDigital',
            'http://www.sat.gob.mx/TimbreFiscalDigital/TimbreFiscalDigital.xsd'
        );

        static::assertXmlStringEqualsXmlFile($basefile, $schemas->getImporterXsd());
    }

    public function testIteratorAggregate() : void
    {
        $data = [
            new Schema('a', 'aaa'),
            new Schema('b', 'bbb'),
            new Schema('c', 'ccc'),
        ];
        $schemas = new Schemas();
        $countSchemas = count($data);
        for ($i = 0; $i < $countSchemas; $i++) {
            $schemas->insert($data[$i]);
        }
        $i = 0;
        foreach ($schemas as $schema) {
            static::assertSame($data[$i], $schema, "Iteration of schema index $i");
            $i = $i + 1;
        }
    }
}
