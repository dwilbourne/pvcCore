<?php

namespace tests\validator\document\xml\schema;

use DOMDocument;
use pvc\validator\document\xml\schema\ValidatorXmlSchema;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected ValidatorXmlSchema $validator;

    protected static string $fixturesSubdir = '/fixtures/';

    public function setUp() : void
    {
        $this->validator = new ValidatorXmlSchema();
    }

    public function getDocument(string $file) : DOMDocument
    {
        $location = static::filesystemFixtureLocation($file);
        if (! file_exists($location)) {
            static::markTestSkipped("The file $location was not found");
        }
        $fileContents = (string) file_get_contents($location);
        $doc = new DOMDocument();
        $doc->loadXML($fileContents);
        return $doc;
    }

    /**
     * Return the location of a file from the fixtures folder
     *
     * @param string $filename
     * @return string
     */
    protected static function filesystemFixtureLocation($filename)
    {
        return __DIR__ . self::$fixturesSubdir . $filename;
    }
}
