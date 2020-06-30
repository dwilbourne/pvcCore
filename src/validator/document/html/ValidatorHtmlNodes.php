<?php declare(strict_types = 1);
/**
 * This file is part of the pvc\htmlValidator package, whic is an adaptation of the
 * rexxars\html-validatorHtml package authored by Espen Hovlandsdal <espen@hovlandsdal.com>.
 *
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version 1.0
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace pvc\validator\document\html;

use Psr\Http\Message\ResponseInterface;
use pvc\charset\Charset;
use pvc\doctype\DocType;
use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentException;
use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentMsg;
use pvc\validator\base\ValidatorInterface;
use pvc\validator\document\html\HttpClient;
use pvc\validator\document\html\ValidatorHtml;

/**
 * Class ValidatorHtmlNodes
 */
class ValidatorHtmlNodes extends ValidatorHtml implements ValidatorInterface
{

    /**
     * @var DocType
     */
    protected DocType $docType;

    /**
     * @var Charset
     */
    protected Charset $charSet;

    /**
     * @var string
     */
    private string $wrapMethod;

    /**
     * @var string
     */
    private string $htmlDocTitle = '<title>Validation Document from NodeWrapper</title>';

    /**
     * ValidatorHtmlNodes constructor.
     * @param DocType|null $dt
     * @param Charset|null $cs
     * @throws InvalidArgumentException
     */
    public function __construct(DocType $dt = null, Charset $cs = null)
    {
        $this->setDocType($dt);
        $this->setCharSet($cs);
        parent::__construct();
    }

    /**
     * @function setDocType
     * @param DocType|null $dt
     * @throws InvalidArgumentException
     */
    public function setDocType(DocType $dt = null) : void
    {
        $dt = $dt ?? new DocType(DocType::HTML5);
        if ($dt->getMarkupLanguage() != 'html') {
            $msg = new InvalidArgumentMsg('Doctype must be an html doctype.');
            throw new InvalidArgumentException($msg);
        }
        $this->docType = $dt;

        switch ($this->docType->getDocType()) {
            case DocType::HTML4_LOOSE:
            case DocType::HTML4_STRICT:
                $this->wrapMethod = 'wrapInHtml4Document';
                break;
            case DocType::HTML5:
                $this->wrapMethod = 'wrapInHtml5Document';
                break;
        }
    }

    /**
     * @function getDocType
     * @return string
     */
    public function getDocType() : string
    {
        return $this->docType->getDocTypeString();
    }

    /**
     * @function setCharSet
     * @param Charset|null $charSet
     */
    public function setCharSet(Charset $charSet = null) : void
    {
        $charSet = $charSet ?? new Charset(Charset::UTF_8);
        $this->charSet  = $charSet;
    }

    /**
     * @function getCharSet
     * @return string
     */
    public function getCharSet() : string
    {
        return $this->charSet->getCharsetString();
    }

    /**
     * Attempts to wrap a set of html tags in a surrounding document
     * @function wrap
     * @param string $nodes
     * @return string
     */
    public function wrap(string $nodes) : string
    {
        $wrapMethod = $this->wrapMethod;
        return $this->$wrapMethod($nodes);
    }

    /**
     * @function wrapInHtml5Document
     * @param string $nodes
     * @return string
     */
    protected function wrapInHtml5Document(string $nodes) : string
    {
        $document  = $this->getDocType();
        $document .= '<html><head>';
        $document .= '<meta charSet="' . $this->getCharSet() . '">';
        $document .= $this->htmlDocTitle;
        $document .= '</head><body>' . $nodes . '</body></html>';
        return $document;
    }

    /**
     * @function wrapInHtml4Document
     * @param string $nodes
     * @param null $charset
     * @param null $parser
     * @return string
     */
    protected function wrapInHtml4Document(string $nodes, $charset = null, $parser = null)
    {
        $contentType = "content=\"text/html; charSet=" . $this->getCharSet() . "\"";

        $document  = $this->getDocType();
        $document .= '<html><head>';
        $document .= '<meta http-equiv="Content-Type" ' . $contentType . '>';
        $document .= $this->htmlDocTitle;
        $document .= '</head><body>' . $nodes . '</body></html>';
        return $document;
    }

    /**
     * @function configureRequest
     * @param string $nodes
     * @throws InvalidArgumentException
     */
    public function configureRequest(string $nodes): void
    {
        // unless otherwise set explicitly, this class is constructed using html5 as the default standard
        $this->client->setDocument($this->wrap($nodes));
        $this->client->setRequestMethod(HttpClient::REQUEST_POST);
    }
}
