<?php declare(strict_types = 1);
/**
 * This file is part of the pvc\htmlValidator package, which is an adaptation of the
 * rexxars\html-validator package authored by Espen Hovlandsdal <espen@hovlandsdal.com>.
 * It was published originally with an MIT license.
 *
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version 1.0
 *
 */

namespace pvc\validator\document\html;

use Psr\Http\Message\ResponseInterface;
use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentException;
use pvc\msg\ErrorExceptionMsg;
use pvc\msg\UserMsg;
use pvc\msg\UserMsgInterface;
use pvc\validator\base\ValidatorInterface;
use pvc\validator\document\html\err\ServerException;
use Throwable;

/**
 * Class ValidatorHtml
 */
abstract class ValidatorHtml implements ValidatorInterface
{
    /**
     * @var HttpClient
     */
    protected HttpClient $client;

    /**
     * @var ResponseValidator
     */
    protected ResponseValidator $responseValidator;

    /**
     * @var ResponseParser
     */
    protected ResponseParser $responseParser;

    /**
     * @var Messages
     */
    protected Messages $messages;

    /**
     * @var MessagesFilter
     */
    protected MessagesFilter $messagesFilter;

    /**
     * @var UserMsgInterface|null
     */
    protected ?UserMsgInterface $errmsg;

    /**
     * ValidatorHtml constructor.
     * @throws InvalidArgumentException
     */
    public function __construct()
    {
        // messagesFilter has Iterator interface and is the inner iterator of MessagesFilter.
        $messages = new Messages();
        $this->setMessages($messages);

        $this->setMessagesFilter(new MessagesFilter($this->getMessages()));
        // set so it reports all messagesFilter
        $this->messagesFilter->setReportingLevel(Message::MESSAGE_TYPE_ALL);
        // set the default failure threshold to warning
        $this->messagesFilter->setFailureThreshold(Message::MESSAGE_TYPE_WARNING);

        $this->client = new HttpClient();
        $this->responseValidator = new ResponseValidator();
        $this->responseParser = new ResponseParser($this->getMessages());
    }

    /**
     * @function getMessages
     * @return Messages
     */
    public function getMessages(): Messages
    {
        return $this->messages;
    }

    /**
     * @function setMessages
     * @param Messages $messages
     */
    public function setMessages(Messages $messages): void
    {
        $this->messages = $messages;
    }

    /**
     * @function getClient
     * @return HttpClient
     */
    public function getClient(): HttpClient
    {
        return $this->client;
    }

    /**
     * @function setClient
     * @param HttpClient $client
     */
    public function setClient(HttpClient $client): void
    {
        $this->client = $client;
    }

    /**
     * @function getValidatorUrl
     * @return string
     */
    public function getValidatorUrl(): string
    {
        return $this->client->getValidatorUrl();
    }

    /**
     * @function setValidatorUrl
     * @param string $validatorUrl
     */
    public function setValidatorUrl(string $validatorUrl): void
    {
        $this->client->setValidatorUrl($validatorUrl);
    }

    /**
     * @function getMessagesFilter
     * @return MessagesFilter
     */
    public function getMessagesFilter(): MessagesFilter
    {
        return $this->messagesFilter;
    }

    /**
     * @function setMessagesFilter
     * @param MessagesFilter $messagesFilter
     */
    public function setMessagesFilter(MessagesFilter $messagesFilter): void
    {
        $this->messagesFilter = $messagesFilter;
    }

    /**
     * @function setReportingLevel
     * @param int $flags
     * @throws \pvc\err\throwable\exception\stock_rebrands\InvalidArgumentException
     */
    public function setReportingLevel(int $flags): void
    {
        $this->messagesFilter->setReportingLevel($flags);
    }

    /**
     * @function getReportingLevel
     * @return int
     */
    public function getReportingLevel(): int
    {
        return $this->messagesFilter->getReportingLevel();
    }

    /**
     * @function setFailureThreshold
     * @param int $failureThreshold
     * @throws \pvc\err\throwable\exception\stock_rebrands\InvalidArgumentException
     */
    public function setFailureThreshold(int $failureThreshold): void
    {
        $this->messagesFilter->setFailureThreshold($failureThreshold);
    }

    /**
     * @function getFailureThreshold
     * @return int
     */
    public function getFailureThreshold() : int
    {
        return $this->messagesFilter->getFailureThreshold();
    }

    /**
     * @function getResponseValidator
     * @return ResponseValidator
     */
    public function getResponseValidator(): ResponseValidator
    {
        return $this->responseValidator;
    }

    /**
     * @function setResponseValidator
     * @param ResponseValidator $rv
     */
    public function setResponseValidator(ResponseValidator $rv): void
    {
        $this->responseValidator = $rv;
    }

    /**
     * @function getResponseParser
     * @return ResponseParser
     */
    public function getResponseParser(): ResponseParser
    {
        return $this->responseParser;
    }

    /**
     * @function setResponseParser
     * @param ResponseParser $rp
     */
    public function setResponseParser(ResponseParser $rp): void
    {
        $this->responseParser = $rp;
    }

    /**
     * @function validate
     * @param string $input
     * @return bool
     * @throws ServerException
     */
    public function validate($input): bool
    {
        $this->configureRequest($input);
        try {
            $response = $this->client->sendRequest();
        } catch (InvalidArgumentException $e) {
            $msgText = $e->getMessage();
            $msg = new UserMsg([], $msgText);
            $this->errmsg = $msg;
            return false;
        } catch (Throwable $e) {
            throw new ServerException($e);
        }

        return $this->validateResponse($response);
    }

    /**
     * @function configureRequest
     * @param string $string
     */
    abstract public function configureRequest(string $string): void;

    /**
     * @function validateResponse
     * @param ResponseInterface $response
     * @return bool
     * @throws \pvc\err\throwable\exception\stock_rebrands\InvalidArgumentException
     */
    public function validateResponse(ResponseInterface $response): bool
    {
        if (!$this->responseValidator->validate($response)) {
            $this->errmsg = $this->responseValidator->getErrMsg();
            return false;
        }

        if (!$this->responseParser->parse((string) $response->getBody())) {
            $this->errmsg = $this->responseParser->getErrmsg();
            return false;
        }

        return $this->messagesFilter->exceedFailureThreshold() ? false : true;
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
