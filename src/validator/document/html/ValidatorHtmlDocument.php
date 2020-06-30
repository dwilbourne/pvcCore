<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\document\html;

use pvc\validator\base\ValidatorInterface;
use pvc\validator\document\html\HttpClient;
use pvc\validator\document\html\ValidatorHtml;

/**
 * Class ValidatorHtmlDocument
 */
class ValidatorHtmlDocument extends ValidatorHtml implements ValidatorInterface
{

    /**
     * @function configureRequest
     * @param string $document
     * @throws \pvc\err\throwable\exception\stock_rebrands\InvalidArgumentException
     */
    public function configureRequest(string $document): void
    {
        $this->client->setDocument($document);
        $this->client->setRequestMethod(HttpClient::REQUEST_POST);
    }
}
