<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\err\throwable;

use pvc\err\throwable\exception\pvc_exceptions\InvalidArrayIndexException;
use pvc\err\throwable\ThrowablesDocumenter;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ThrowablesDocumenterTest extends TestCase
{
    protected string $pvcExceptionsDir;
    protected ThrowablesDocumenter $documenter;

    public function setUp() : void
    {
        // pick an exception that exists in the pvc Exceptions package
        $reflection = new ReflectionClass(InvalidArrayIndexException::class);
        $sampleClassFileName = $reflection->getFileName() ?: '';
        $this->pvcExceptionsDir = dirname($sampleClassFileName);
        $this->documenter = new ThrowablesDocumenter();
    }


    public function testDocumenter() : void
    {
        $throwables = $this->documenter->generateThrowables($this->pvcExceptionsDir);
        foreach ($throwables as $fqClassName => $filePath) {
            self::assertTrue(in_array('Throwable', class_implements($fqClassName)));
        }
    }
}
