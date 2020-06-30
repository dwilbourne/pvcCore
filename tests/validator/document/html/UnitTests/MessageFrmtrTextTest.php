<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\document\html\UnitTests;

use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentException;
use pvc\validator\document\html\Message;
use pvc\validator\document\html\MessageFrmtrText;
use PHPUnit\Framework\TestCase;

class MessageFrmtrTextTest extends TestCase
{
    protected MessageFrmtrText $frmtr;

    public function setUp() : void
    {
        $this->frmtr = new MessageFrmtrText();
    }

    public function testBadArgument() : void
    {
        $input = 'foo';
        self::expectException(InvalidArgumentException::class);
        /** @phpstan-ignore-next-line */
        $this->frmtr->format($input);
    }

    /**
     * Ensure proper plain-text formatting of message
     */
    public function testCorrectPlainTextFormatting() : void
    {
        $data = [
            'type' => 'error',
            'subtype' => '',
            'lastLine' => 2,
            'firstColumn' => 3,
            'lastColumn' => 4,
            'hiliteStart' => 5,
            'hiliteLength' => 6,
            'message' => 'Foobar',
            'extract' => '<strong>Foo</strong>',
        ];

        $message = new Message($data);

        $format = '%s' . PHP_EOL;
        $format .= '%s' . PHP_EOL;
        $format .= 'From line %d, column %d to line %d, column %d' . PHP_EOL;
        $format .= '%s';

        $expectedMessage = sprintf(
            $format,
            'ERROR',
            'Foobar',
            $data['lastLine'],
            $data['firstColumn'],
            $data['lastLine'],
            $data['lastColumn'],
            $data['extract']
        );

        static::assertSame($expectedMessage, $this->frmtr->format($message));
    }
}
