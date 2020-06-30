<?php declare(strict_types = 1);

namespace pvc\validator\document\xml\schema;

use DOMDocument;
use DOMXPath;
use pvc\err\throwable\exception\pvc_exceptions\InvalidValueException;
use pvc\err\throwable\exception\pvc_exceptions\InvalidValueMsg;
use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentException;
use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentMsg;
use pvc\msg\UserMsgInterface;
use pvc\validator\document\xml\schema\err\BuildSchemasException;
use pvc\validator\document\xml\schema\err\ValidateSchemaException;
use pvc\validator\base\ValidatorInterface;
use pvc\xml\LibXmlWrapper\LibXmlErrorHandler;
use pvc\xml\LibXmlWrapper\LibXmlExecutionEnvironment;
use SimpleXMLElement;

/**
 * This class is an XML validator capable of validating an XML doc with multiple schemas
 */
class ValidatorXmlSchema implements ValidatorInterface
{
    /**
     * @var Schemas
     */
    protected Schemas $schemas;

    /**
     * @var array
     */
    protected array $libXmlErrors = [];

    /**
     * @var UserMsgInterface
     */
    protected UserMsgInterface $errmsg;

    /**
     * ValidatorXmlSchema constructor.
     */
    public function __construct()
    {
        $this->schemas = new Schemas();
    }

    /**
     * @function setSchemas
     * @param Schemas $schemas
     */
    public function setSchemas(Schemas $schemas): void
    {
        $this->schemas = $schemas;
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
     * @param string $namespace
     * @param string $location
     */
    public function addSchema(string $namespace, string $location): void
    {
        $this->schemas->create($namespace, $location);
    }

    /**
     * @function schemaCount
     * @return int
     */
    public function schemaCount(): int
    {
        return $this->schemas->count();
    }

    /**
     * @function getLibXmlErrors
     * @return array
     */
    public function getLibXmlErrors(): array
    {
        return $this->libXmlErrors;
    }

    /**
     * @function buildSchemasFromDocument
     * @param DOMDocument $document
     * @return bool
     * @throws BuildSchemasException
     */
    public function buildSchemasFromDocument(DOMDocument $document): bool
    {
        if (false === ($xml = $document->saveXML())) {
            // difficult to test this block of code - not really sure how to make the saveXML method fail
            // in this context but in theory it can return false;
            $addtlText = 'Unable to save DOMDocument as xml text string';
            $msg = new InvalidArgumentMsg('DOMDocument', $addtlText);
            throw new InvalidArgumentException($msg);
        }
        $sxe = new SimpleXMLElement($xml);
        // get the prefix asociated with the  http://www.w3.org/2001/XMLSchema-instance namespace
        $schemaInstanceNamespace = 'http://www.w3.org/2001/XMLSchema-instance';
        $namespaces = $sxe->getDocNamespaces(true);
        $xsi = array_search($schemaInstanceNamespace, $namespaces);
        // if there is no prefix referencing the W3 schema instance namespace, then there is no valid schema location
        // attribute within the document - we're done.
        if (!$xsi) {
            return false;
        }

        // get the http://www.w3.org/2001/XMLSchema-instance namespace prefix (it might not be 'xsi')
        // $xsi = $document->lookupPrefix('http://www.w3.org/2001/XMLSchema-instance');

        $xpath = new DOMXPath($document);
        // get all the xsi:schemaLocation attributes in the document
        $schemasList = $xpath->query("//@$xsi:schemaLocation");

        // schemaLocation attribute not found, no need to continue
        if (false === $schemasList || 0 === $schemasList->length) {
            return false;
        }

        // process every schemaLocation pair
        foreach ($schemasList as $node) {
            // get the node content
            $content = $node->nodeValue;

            // use preg_split to parse namespace and uri
            $parts = preg_split('/[\s]+/', $content) ?: [];
            $partsCount = count($parts);

            // $partsCount has to be an even number if the schema namespace / schema location syntax is correct
            if (0 !== ($partsCount % 2)) {
                throw new BuildSchemasException($content);
            }
            // insert the uris pairs into the schemas
            for ($k = 0; $k < $partsCount; $k = $k + 2) {
                $this->schemas->create($parts[$k], $parts[$k + 1]);
            }
        }

        return true;
    }

    /**
     * @function validate
     * @param DOMDocument $document
     * @return bool
     * @throws BuildSchemasException
     * @throws InvalidArgumentException
     * @throws ValidateSchemaException
     * @throws \pvc\err\throwable\exception\pvc_exceptions\InvalidArrayValueException
     */
    public function validate($document): bool
    {
        if (!$document instanceof DOMDocument) {
            $msg = new InvalidArgumentMsg('DOMDocument');
            throw new InvalidArgumentException($msg);
        }

        if (($this->getSchemas()->count() == 0) && (!$this->buildSchemasFromDocument($document))) {
            throw new ValidateSchemaException();
        }

        $xsd = $this->schemas->getImporterXsd();
        // difficult to test this block of code - not really sure how to make the saveXML method fail
        // in this context but in theory it can return false;
        if (false === ($xml = $xsd->saveXML())) {
            $addtlText = 'Unable to save xsd as xml text string';
            $msg = new InvalidValueMsg('xsd', $addtlText);
            throw new InvalidValueException($msg);
        }

        $env = new LibXmlExecutionEnvironment();
        $callable = function () use ($document, $xml) {
            return $document->schemaValidateSource($xml);
        };
        $result = $env->executeCallable($callable);
        if ($env->hasErrors()) {
            $this->libXmlErrors = $env->getErrors();
            $handler = new LibXmlErrorHandler();
            $handler->setErrors($this->libXmlErrors);
            $this->errmsg = $handler->getMsgCollection();
        }
        return $result;
    }

    /**
     * @function getLastErrorText
     * @return string|null
     */
    public function getLastErrorText(): ?string
    {
        if (0 < count($this->libXmlErrors)) {
            $lastError = $this->libXmlErrors[0];
            return $lastError->message;
        } else {
            return null;
        }
    }

    /**
     * @function getErrMsg
     * @return UserMsgInterface|null
     */
    public function getErrMsg(): ?UserMsgInterface
    {
        return $this->errmsg;
    }
}
