<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\document\html;

use DOMDocument;
use pvc\validator\base\ValidatorInterface;
use pvc\validator\document\xml\schema\ValidatorXmlSchema;

/**
 * Class ValidatorXmlNodes
 */
class ValidatorXmlDocument extends ValidatorHtml implements ValidatorInterface
{
    /**
     * instructs whether to load external entities as part of the validation.  There's a
     * potential security issue (XXE injection attack) so the default is false;
     *
     * @var bool
     */
    protected bool $loadXXE = false;

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
     * @function configureRequest
     * @param string $document
     * @throws \pvc\err\throwable\exception\stock_rebrands\InvalidArgumentException
     * @throws \pvc\validator\document\xml\schema\err\BuildSchemasException
     */
    public function configureRequest(string $document): void
    {
        $this->client->setDocument($document);
        $this->client->parseXml(true);
        if ($this->getLoadXXE()) {
            $this->client->loadXXE(true);
        }

        $v = new ValidatorXmlSchema();
        $dom = new DOMDocument();
        $dom->loadXML($document);
        $v->buildSchemasFromDocument($dom);
        foreach ($v->getSchemas() as $schema) {
            $this->client->addSchema($schema);
        }

        $this->client->setRequestMethod(HttpClient::REQUEST_POST);
    }
}
