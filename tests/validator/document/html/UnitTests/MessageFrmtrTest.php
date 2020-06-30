<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\document\html\UnitTests;

use Mockery;
use PHPUnit\Framework\TestCase;
use pvc\validator\document\html\Message;
use pvc\validator\document\html\MessageFrmtr;

class MessageFrmtrTest extends TestCase
{
    /** @phpstan-ignore-next-line */
    protected $frmtr;

    protected array $data = [
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

    public function setUp() : void
    {
        $this->frmtr = Mockery::mock(MessageFrmtr::class)->makePartial();
    }

    public function testGetLocatorText() : void
    {
        $message = new Message($this->data);
        $format = 'From line %d, column %d to line %d, column %d';

        $expectedMessage = sprintf(
            $format,
            $this->data['lastLine'],
            $this->data['firstColumn'],
            $this->data['lastLine'],
            $this->data['lastColumn'],
        );

        static::assertSame($expectedMessage, $this->frmtr->getLocatorText($message));
    }
    
    public function testLastLineIsZero() : void
    {
        $this->data['lastLine'] = 0;
        $message = new Message($this->data);
        self::assertEquals('', $this->frmtr->getLocatorText($message));
    }

    public function testParseExtract(): void
    {
        $data = [
            'type' => 'error',
            'lastLine' => 1,
            'firstColumn' => 15,
            'lastColumn' => 37,
            'hiliteStart' => 15,
            'hiliteLength' => 21,
            'message' => '“Imbo” is simply too awesome for words',
            'extract' => 'How awesome is <strong>Imbo</strong>?',
        ];
        $message = new Message($data);
        $expected['prehighlight'] = 'How awesome is ';
        $expected['highlight'] = '<strong>Imbo</strong>';
        $expected['posthighlight'] = '?';

        self::assertEqualsCanonicalizing(
            $expected,
            $this->frmtr->parseExtract(
                $message->getExtract(),
                $message->getHighlightStart(),
                $message->getHighlightLength()
            )
        );
    }
}
