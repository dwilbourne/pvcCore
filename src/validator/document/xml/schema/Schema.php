<?php declare(strict_types = 1);

namespace pvc\validator\document\xml\schema;

/**
 * Schema immutable object
 */
class Schema
{
    /**
     * @var string
     */
    private string $namespace;

    /**
     * @var string
     */
    private string $location;

    /**
     * Schema constructor.
     * @param string $namespace
     * @param string $location
     */
    public function __construct(string $namespace, string $location)
    {
        $this->namespace = $namespace;
        $this->location = $location;
    }

    /**
     * @function getNamespace
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * @function getLocation
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }
}
