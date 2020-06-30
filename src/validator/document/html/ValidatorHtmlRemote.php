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
 * Checks the validity of the html that is returned by requesting a page from a web server
 *
 * Class ValidatorHtmlRemote.
 */
class ValidatorHtmlRemote extends ValidatorHtml implements ValidatorInterface
{
    /**
     * @var bool
     */
    protected bool $checkNon200Pages = false;

    /**
     * Set to true if you want to validate pages that return status codes which are not in the 2xx range
     * @function setCheckNon200Pages
     * @param bool $value
     */
    public function setCheckNon200Pages(bool $value) : void
    {
        $this->checkNon200Pages = $value;
    }

    /**
     * @function getCheckNon200Pages
     * @return bool
     */
    public function getCheckNon200Pages() : bool
    {
        return $this->checkNon200Pages;
    }

    /**
     * @function configureRequest
     * @param string $url
     * @throws \pvc\err\throwable\exception\stock_rebrands\InvalidArgumentException
     */
    public function configureRequest(string $url) : void
    {
        if ($this->checkNon200Pages) {
            $this->client->setCheckErrorPages(true);
        }
        $this->client->setUriToGet($url);
        $this->client->setRequestMethod(HttpClient::REQUEST_GET);
    }
}
