<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\validator\document\html\UnitTests;

use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentException;
use pvc\validator\document\html\Message;
use pvc\validator\document\html\MessageFrmtrHtml;
use PHPUnit\Framework\TestCase;

class MessageFrmtrHtmlTest extends TestCase
{
    protected MessageFrmtrHtml $frmtr;

    public function setUp() : void
    {
        $this->frmtr = new MessageFrmtrHtml();
    }

    public function testBadArgument() : void
    {
        $input = 'foo';
        self::expectException(InvalidArgumentException::class);
        /** @phpstan-ignore-next-line */
        $this->frmtr->format($input);
    }

    public function testSetGetHighlightClassName() : void
    {
        self::assertEquals('hilite', $this->frmtr->getHighlightClassName());
        $className = 'lowlight';
        $this->frmtr->setHighlightClassName($className);
        self::assertEquals($className, $this->frmtr->getHighlightClassName());
    }

    public function testSetGetContainerTagClassName() : void
    {
        self::assertEquals('', $this->frmtr->getContainerTagClassName());
        $className = 'foobar';
        $this->frmtr->setContainerTagClassName($className);
        self::assertEquals($className, $this->frmtr->getContainerTagClassName());
    }


    /**
     * Ensure proper HTML formatting of message
     */
    public function testCorrectHtmlFormatting() : void
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

        $expected  = '<div><strong>ERROR</strong></div>';
        $expected .= '<div>&ldquo;Imbo&rdquo; is simply too awesome for words</div>';
        $expected .= '<div>From line 1, column 15 to line 1, column 37</div>';
        $expected .= '<div>How awesome is <span class="hilite">&lt;strong&gt;Imbo&lt;/strong&gt;?</span></div>';

        static::assertSame($expected, $this->frmtr->format($message));

        $this->frmtr->setHighlightClassName('pimp-pelican');
        $this->frmtr->setContainerTagClassName('imbo-dimbo');

        $expected  = '<div class="imbo-dimbo"><strong>ERROR</strong></div>';
        $expected .= '<div class="imbo-dimbo">&ldquo;Imbo&rdquo; is simply too awesome for words</div>';
        $expected .= '<div class="imbo-dimbo">From line 1, column 15 to line 1, column 37</div>';
        $expected .= '<div class="imbo-dimbo">How awesome is <span class="pimp-pelican">&lt;';
        $expected .= 'strong&gt;Imbo&lt;/strong&gt;?</span></div>';
        static::assertSame($expected, $this->frmtr->format($message));
    }
}
