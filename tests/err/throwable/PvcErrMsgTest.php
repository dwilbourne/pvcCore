<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\err\throwable;

use PHPUnit\Framework\TestCase;
use pvc\err\throwable\exception\pvc_exceptions\OutOfContextMethodCallMsg;
use pvc\err\throwable\exception\pvc_exceptions\InvalidArrayValueMsg;
use pvc\intl\err\InvalidLocaleMsg;
use pvc\err\throwable\exception\pvc_exceptions\InvalidTypeMsg;
use pvc\err\throwable\exception\pvc_exceptions\InvalidValueMsg;
use pvc\err\throwable\exception\pvc_exceptions\InvalidArrayIndexMsg;
use pvc\err\throwable\exception\pvc_exceptions\InvalidAttributeNameMsg;
use pvc\err\throwable\exception\pvc_exceptions\InvalidFilenameMsg;
use pvc\err\throwable\exception\pvc_exceptions\InvalidPHPVersionMsg;
use pvc\err\throwable\exception\pvc_exceptions\PregMatchFailureMsg;
use pvc\err\throwable\exception\pvc_exceptions\PregReplaceFailureMsg;
use pvc\err\throwable\exception\pvc_exceptions\UnsetAttributeMsg;
use pvc\err\throwable\exception\stock_rebrands\BadFunctionCallMsg;
use pvc\err\throwable\exception\stock_rebrands\BadMethodCallMsg;
use pvc\err\throwable\exception\stock_rebrands\ClosedGeneratorMsg;
use pvc\err\throwable\exception\stock_rebrands\DOMArgumentMsg;
use pvc\err\throwable\exception\stock_rebrands\DOMFunctionMsg;
use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentMsg;
use pvc\err\throwable\exception\stock_rebrands\InvalidDataTypeMsg;
use pvc\formatter\msg\FrmtrMsgText;

/**
 * Class PvcErrMsgTest
 */
class PvcErrMsgTest extends TestCase
{

    protected FrmtrMsgText $frmtr;

    public function setUp(): void
    {
        $this->frmtr = new FrmtrMsgText();
    }

    public function testIncompleteObjectConfigurationMsg() : void
    {
        $objectName = 'foo';
        $methodName = 'bar';
        $additionalMsg = 'this is an additional message';
        $msg = new OutOfContextMethodCallMsg($objectName, $methodName, $additionalMsg);
        self::assertTrue(is_string($this->frmtr->format($msg)));
        self::assertTrue(0 < strlen($this->frmtr->format($msg)));
    }

    public function testInvalidValueMsg() : void
    {
        $name = 'foo';
        $value = 'bar';
        $additionMessage = 'this is an additional message';
        $msg = new InvalidValueMsg($name, $value, $additionMessage);
        self::assertTrue(is_string($this->frmtr->format($msg)));
        self::assertTrue(0 < strlen($this->frmtr->format($msg)));
    }

    public function testInvalidArgumentMsg() : void
    {
        $expectedDataType = 'foo';
        $msg = new InvalidArgumentMsg($expectedDataType);
        self::assertTrue(is_string($this->frmtr->format($msg)));
        self::assertTrue(0 < strlen($this->frmtr->format($msg)));
    }

    public function testInvalidArrayIndexMsg() : void
    {
        $indexValue = 'foo';
        $additionalMsg = 'this is an additional message.';
        $msg = new InvalidArrayIndexMsg($indexValue, $additionalMsg);
        self::assertTrue(is_string($this->frmtr->format($msg)));
        self::assertTrue(0 < strlen($this->frmtr->format($msg)));
    }

    public function testInvalidArrayValueMsg() : void
    {
        $arrayValue = 'foo';
        $msg = new InvalidArrayValueMsg($arrayValue);
        self::assertTrue(is_string($this->frmtr->format($msg)));
        self::assertTrue(0 < strlen($this->frmtr->format($msg)));
    }

    public function testInvalidAttributeNameMsg() : void
    {
        $attributeName = 'foo';
        $msg = new InvalidAttributeNameMsg($attributeName);
        self::assertTrue(is_string($this->frmtr->format($msg)));
        self::assertTrue(0 < strlen($this->frmtr->format($msg)));
    }

    public function testInvalidTypeMsg() : void
    {
        $name = 'foo';
        $types = ['int', 'string'];
        $msg = new InvalidTypeMsg($name, $types);
        self::assertTrue(is_string($this->frmtr->format($msg)));
        self::assertTrue(0 < strlen($this->frmtr->format($msg)));
    }

    public function testInvalidFilenameMsg() : void
    {
        $filename = ',/.,.,';
        $msg = new InvalidFilenameMsg($filename);
        self::assertTrue(is_string($this->frmtr->format($msg)));
        self::assertTrue(0 < strlen($this->frmtr->format($msg)));
    }

    public function testInvalidLocaleMsg() : void
    {
        $locale = '';
        $msg = new InvalidLocaleMsg($locale);
        self::assertTrue(is_string($this->frmtr->format($msg)));
        self::assertTrue(0 < strlen($this->frmtr->format($msg)));
    }

    public function testInvalidPhpVersionMsg() : void
    {
        $minPhpVersion = '7.0.0';
        $msg = new InvalidPhpVersionMsg($minPhpVersion);
        self::assertTrue(is_string($this->frmtr->format($msg)));
        self::assertTrue(0 < strlen($this->frmtr->format($msg)));
    }

    public function testPregMatchFailureMsg() : void
    {
        $regex = '/abc/';
        $subject = 'xyz';
        $msg = new PregMatchFailureMsg($regex, $subject);
        self::assertTrue(is_string($this->frmtr->format($msg)));
        self::assertTrue(0 < strlen($this->frmtr->format($msg)));
    }

    public function testPregReplaceFailureMsg() : void
    {
        $regex = '/abc/';
        $subject = 'xyz';
        $replace = '123';
        $msg = new PregReplaceFailureMsg($regex, $subject, $replace);
        self::assertTrue(is_string($this->frmtr->format($msg)));
        self::assertTrue(0 < strlen($this->frmtr->format($msg)));
    }

    public function testUnsetAttributeMsg() : void
    {
        $attributeName = 'foo';
        $msg = new UnsetAttributeMsg($attributeName);
        self::assertTrue(is_string($this->frmtr->format($msg)));
        self::assertTrue(0 < strlen($this->frmtr->format($msg)));
    }

    public function testBadFunctionCallMsg() : void
    {
        $callbackName = 'foo';
        $msg = new BadFunctionCallMsg($callbackName);
        self::assertTrue(is_string($this->frmtr->format($msg)));
        self::assertTrue(0 < strlen($this->frmtr->format($msg)));
    }

    public function testBadMethodCallMsg() : void
    {
        $methodName = 'foo';
        $msg = new BadMethodCallMsg($methodName);
        self::assertTrue(is_string($this->frmtr->format($msg)));
        self::assertTrue(0 < strlen($this->frmtr->format($msg)));
    }

    public function testClosedGeneratorMsg() : void
    {
        $generatorName = 'foo';
        $msg = new ClosedGeneratorMsg($generatorName);
        self::assertTrue(is_string($this->frmtr->format($msg)));
        self::assertTrue(0 < strlen($this->frmtr->format($msg)));
    }

    public function testDOMArgumentMsg() : void
    {
        $argName = 'foo';
        $methodName = 'bar';
        $msg = new DOMArgumentMsg($argName, $methodName);
        self::assertTrue(is_string($this->frmtr->format($msg)));
        self::assertTrue(0 < strlen($this->frmtr->format($msg)));
    }

    public function testDOMFunctionMsg() : void
    {
        $DOMFunctionName = 'bar';
        $msg = new DOMFunctionMsg($DOMFunctionName);
        self::assertTrue(is_string($this->frmtr->format($msg)));
        self::assertTrue(0 < strlen($this->frmtr->format($msg)));
    }

    public function testInvalidDataTypeMsg() : void
    {
        $dataType = 'bar';
        $msg = new InvalidDataTypeMsg($dataType);
        self::assertTrue(is_string($this->frmtr->format($msg)));
        self::assertTrue(0 < strlen($this->frmtr->format($msg)));
    }
}
