<?php declare(strict_types = 1);

namespace pvc\validator\document\xml\schema;

use ArrayIterator;
use Countable;
use DOMDocument;
use DOMElement;
use InvalidArgumentException;
use IteratorAggregate;
use Traversable;

/**
 * Collection of Schema objects, used by SchemaValidator
 */
class Schemas implements IteratorAggregate, Countable
{
    /**
     * @var array
     */
    private array $schemas = [];

    /**
     * Return the XML of an Xsd that includes all the namespaces and uris
     * @function getImporterXsd
     * @return DOMDocument
     */
    public function getImporterXsd(): DOMDocument
    {
        $xsd = new DOMDocument('1.0', 'utf-8');
        $xsd->loadXML('<xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema"/>');
        $document = $xsd->documentElement;
        foreach ($this->schemas as $schema) {
            $node = $xsd->createElementNS('http://www.w3.org/2001/XMLSchema', 'import');
            $node->setAttribute('namespace', $schema->getNamespace());
            $node->setAttribute('schemaLocation', str_replace('\\', '/', $schema->getLocation()));
            /** @phpstan-ignore-next-line */
            $document->appendChild($node);
        }
        return $xsd;
    }

    /**
     * Create a new schema and inserts it to the collection
     * The returned object is the schema
     * @function create
     * @param string $namespace
     * @param string $location
     * @return Schema
     * @return Schema
     */
    public function create(string $namespace, string $location): Schema
    {
        return $this->insert(new Schema($namespace, $location));
    }

    /**
     * Insert a schema to the collection
     * The returned object is the same schema
     * @function insert
     * @param Schema $schema
     * @return Schema
     */
    public function insert(Schema $schema): Schema
    {
        $this->schemas[$schema->getNamespace()] = $schema;
        return $schema;
    }

    /**
     * Remove a schema
     * @function remove
     * @param string $namespace
     * @return void
     */
    public function remove(string $namespace)
    {
        unset($this->schemas[$namespace]);
    }

    /**
     * Return the complete collection of schemas as an associative array
     * @function all
     * @return array<string, Schema>
     */
    public function all(): array
    {
        return $this->schemas;
    }

    /**
     * @function exists
     * @param string $namespace
     * @return bool
     */
    public function exists(string $namespace): bool
    {
        return array_key_exists($namespace, $this->schemas);
    }

    /**
     * Get an schema object by its namespace
     * @function item
     * @param string $namespace
     * @return Schema
     */
    public function item(string $namespace): Schema
    {
        if (! $this->exists($namespace)) {
            throw new InvalidArgumentException("Namespace $namespace does not exists in the schemas");
        }
        return $this->schemas[$namespace];
    }

    /**
     * @function count
     * @return int
     */
    public function count()
    {
        return count($this->schemas);
    }

    /**
     * @function getIterator
     * @return ArrayIterator|Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->schemas);
    }

    /**
     * @function getSchemaLocations
     * @return array
     */
    public function getSchemaLocations() : array
    {
        $result = [];
        foreach ($this->schemas as $schema) {
            $result[] = $schema->getLocation();
        }
        return $result;
    }
}
