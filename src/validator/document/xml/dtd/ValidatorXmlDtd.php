<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\document\xml\dtd;

use DOMDocument;
use pvc\err\throwable\exception\pvc_exceptions\InvalidArrayValueException;
use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentException;
use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentMsg;
use pvc\msg\UserMsgInterface;
use pvc\validator\base\ValidatorInterface;
use pvc\xml\LibXmlWrapper\LibXmlErrorHandler;
use pvc\xml\LibXmlWrapper\LibXmlExecutionEnvironment;

/**
 * Class ValidatorXmlDtd
 */
class ValidatorXmlDtd implements ValidatorInterface
{
    /**
     * @var UserMsgInterface
     */
    protected UserMsgInterface $errmsg;

    /**
     * @var array
     */
    protected array $libXmlErrors = [];

    /**
     * @function getLibXmlErrors
     * @return array
     */
    public function getLibXmlErrors(): array
    {
        return $this->libXmlErrors;
    }

    /**
     * @function validate
     * @param DOMDocument $document
     * @return bool
     * @throws InvalidArgumentException
     * @throws InvalidArrayValueException
     */
    public function validate($document): bool
    {
        // if the document is html, kick it out.  Validating against the actual W3 server takes at least a minute.
        // Use the ValidatorHtml class instead.
        if ((!$document instanceof DOMDocument) || ($this->documentClaimsToBeHtml($document))) {
            $msg = new InvalidArgumentMsg('pvc DOMDocument containing XML');
            throw new InvalidArgumentException($msg);
        }

        $env = new LibXmlExecutionEnvironment();
        $callable = function () use ($document) {
            return $document->validate();
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
     * @function getErrMsg
     * @return UserMsgInterface|null
     */
    public function getErrMsg(): ?UserMsgInterface
    {
        return $this->errmsg;
    }

    /**
     * @function documentClaimsToBeHtml
     * @param DOMDocument $document
     * @return bool
     */
    public function documentClaimsToBeHtml(DOMDocument $document): bool
    {
        if (is_null($document->doctype)) {
            return false;
        } else {
            return (false !== stripos($document->doctype->publicId, 'html'));
        }
    }
}
