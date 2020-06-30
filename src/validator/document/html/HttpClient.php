<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\document\html;

use finfo;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentException;
use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentMsg;
use pvc\parser\file\DOM\MarkupSniffer;
use pvc\validator\document\xml\schema\Schema;
use pvc\validator\document\xml\schema\Schemas;

/**
 * Class HttpClient
 */
class HttpClient
{
    public const DEFAULT_VALIDATOR_URL = 'https://validator.nu';

    public const REQUEST_GET = 1;
    public const REQUEST_POST = 2;

    /**
     * @var string
     */
    protected string $validatorUrl;

    /**
     * @var bool
     */
    protected bool $loadXXE = false;

    /**
     * @var bool
     */
    protected bool $checkErrorPages = false;

    /**
     * @var string
     */
    protected string $uriToGet;

    /**
     * @var string
     */
    protected string $document;

    /**
     * @var int
     */
    protected int $requestMethod;

    /**
     * @var bool
     */
    protected bool $parseXml = false;

    /**
     * @var Schemas
     */
    protected Schemas $schemas;

    /**
     * @var array|string[]
     */
    protected array $validRequestMethods = [
      self::REQUEST_GET => 'get',
      self::REQUEST_POST => 'post'
    ];

    /**
     * HttpClient constructor.
     */
    public function __construct()
    {
        $this->setValidatorUrl(self::DEFAULT_VALIDATOR_URL);
        $this->schemas = new Schemas();
    }

    /**
     * @function getValidatorUrl
     * @return string
     */
    public function getValidatorUrl(): string
    {
        return $this->validatorUrl;
    }

    /**
     * @function setValidatorUrl
     * @param string $validatorUrl
     */
    public function setValidatorUrl(string $validatorUrl): void
    {
        $this->validatorUrl = $validatorUrl;
    }

    /**
     * @function getLoadXXE
     * @return bool
     */
    public function getLoadXXE(): bool
    {
        return $this->loadXXE;
    }

    /**
     * @function loadXXE
     * @param bool $loadXXE
     */
    public function loadXXE(bool $loadXXE): void
    {
        $this->loadXXE = $loadXXE;
    }

    /**
     * @function getParseXml
     * @return bool
     */
    public function getParseXml(): bool
    {
        return $this->parseXml;
    }

    /**
     * @function parseXml
     * @param bool $parseXml
     */
    public function parseXml(bool $parseXml): void
    {
        $this->parseXml = $parseXml;
    }

    /**
     * @function getSchemas
     * @return Schemas
     */
    public function getSchemas(): Schemas
    {
        return $this->schemas;
    }

    /**
     * @function addSchema
     * @param Schema $schema
     */
    public function addSchema(Schema $schema): void
    {
        $this->schemas->insert($schema);
    }

    /**
     * @function setCheckErrorPages
     * @param bool $checkErrorPages
     */
    public function setCheckErrorPages(bool $checkErrorPages) : void
    {
        $this->checkErrorPages = $checkErrorPages;
    }

    /**
     * @function getCheckErrorPages
     * @return bool
     */
    public function getCheckErrorPages() : bool
    {
        return $this->checkErrorPages;
    }

    /**
     * @function setUriToGet
     * @param string $uri
     */
    public function setUriToGet(string $uri) : void
    {
        $this->uriToGet = $uri;
    }

    /**
     * @function getUriToGet
     * @return string
     */
    public function getUriToGet() : string
    {
        return $this->uriToGet;
    }

    /**
     * @function getDocument
     * @return string
     */
    public function getDocument(): string
    {
        return $this->document;
    }

    /**
     * @function setDocument
     * @param string $document
     */
    public function setDocument(string $document): void
    {
        $this->document = $document;
    }

    /**
     * @function getRequestMethod
     * @return int
     */
    public function getRequestMethod(): int
    {
        return $this->requestMethod;
    }

    /**
     * @function setRequestMethod
     * @param int $requestMethodConstant
     * @throws InvalidArgumentException
     */
    public function setRequestMethod(int $requestMethodConstant) : void
    {
        if (!isset($this->validRequestMethods[$requestMethodConstant])) {
            $msg = new InvalidArgumentMsg('request method constant from the HttpClient class.');
            throw new InvalidArgumentException($msg);
        }
        $this->requestMethod = $requestMethodConstant;
    }

    /**
     * @function createClientParams
     * @return array
     */
    private function createClientParams() : array
    {
        return [
            'base_uri' => $this->getValidatorUrl(),
            'headers' => ['User-Agent' => 'pvc/ValidatorHtml']
        ];
    }

    /**
     * @function createHeaders
     * @param string $document
     * @return array
     * @throws \pvc\regex\err\RegexBadPatternException
     * @throws \pvc\regex\err\RegexInvalidMatchIndexException
     * @throws \pvc\regex\err\RegexPatternUnsetException
     */
    public function createHeaders(string $document) : array
    {

        // be aware that finfo looks at individual characters in the file contents for the charset and does not
        // inspect the file for charset declarations.  So even if the doc contains
        // a declaration like charset=utf-8, if finfo finds only ascii characters, it
        // will come back with charset=us-ascii.  The validator will not report this an an error
        // but it does create an informational message.  To remedy this, this method uses the MarkupSniffer class
        // to get the charset if possible

        $finfo = new finfo(FILEINFO_MIME);
        $mimeType = $finfo->buffer($document);
        // I can't find an example where $mimeType evaluates to false, but in theory it can be based on the
        // documentation.
        if (false === $mimeType) {
            $addtlMsg = 'Unable to get mime type (media type) from document.';
            $msg = new InvalidArgumentMsg('html document', $addtlMsg);
            throw new InvalidArgumentException($msg);
        }

        $ms = new MarkupSniffer();
        $ms->sniff($document);
        if (!is_null($ms->getCharset())) {
            // all non-whitespace characters after the 'charset='
            $pattern = "/charset=\S*/";
            $replacement = "charset=" . $ms->getCharset()->getCharsetString();
            $mimeType = preg_replace($pattern, $replacement, $mimeType);
        }

        return ['Content-Type' => $mimeType];
    }

    /**
     * @function createQueryArray
     * @return array|string[]
     */
    public function createQueryArray() : array
    {
        $result = ['out' => 'json'];

        if ($this->getParseXml()) {
            $result['parser'] = 'xml';
        }
        if ($this->loadXXE) {
            $result['parser'] = 'xmldtd';
        }
        if (count($this->schemas) > 0) {
            $result['schemas'] = implode(' ', $this->getSchemas()->getSchemaLocations());
        }
        if ($this->checkErrorPages) {
            $result['checkerrorpages'] = 'yes';
        }
        if (isset($this->uriToGet)) {
            $result['doc'] = $this->uriToGet;
        }
        return $result;
    }

    /**
     * @function post
     * @return ResponseInterface
     * @throws \pvc\regex\err\RegexBadPatternException
     * @throws \pvc\regex\err\RegexInvalidMatchIndexException
     * @throws \pvc\regex\err\RegexPatternUnsetException
     */
    public function post() : ResponseInterface
    {

        $client = new Client($this->createClientParams());

        return $client->request(
            'POST',
            '',
            [
                'body' => $this->getDocument(),
                'headers' => $this->createHeaders($this->getDocument()),
                'query' => $this->createQueryArray(),
            ]
        );
    }

    /**
     * @function get
     * @return ResponseInterface
     */
    public function get() : ResponseInterface
    {

        $client = new Client($this->createClientParams());

        return $client->get('', [
            'query' => $this->createQueryArray(),
        ]);
    }

    /**
     * @function sendRequest
     * @return ResponseInterface
     */
    public function sendRequest() : ResponseInterface
    {
        $method = $this->validRequestMethods[$this->getRequestMethod()];
        return $this->$method();
    }
}
