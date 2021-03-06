<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\parser;

use pvc\msg\UserMsgInterface;

/**
 * Parser creates a few default implementation methods for child classes that implement ParserInterface.
 *
 * Class Parser
 */
abstract class Parser
{
    /**
     * @var mixed
     */
    protected $parsedValue;

    /**
     * @var UserMsgInterface|null
     */
    protected ?UserMsgInterface $errmsg;

    /**
     * @function getParsedValue
     * @return mixed
     */
    public function getParsedValue()
    {
        return $this->parsedValue;
    }

    /**
     * @function setParsedValue
     * @param mixed $parsedValue
     */
    protected function setParsedValue($parsedValue): void
    {
        $this->parsedValue = $parsedValue;
    }

    /**
     * @function getErrmsg
     * @return UserMsgInterface|null
     */
    public function getErrmsg(): ?UserMsgInterface
    {
        return $this->errmsg;
    }

    /**
     * @function setErrmsg
     * @param UserMsgInterface|null $msg
     */
    protected function setErrmsg(UserMsgInterface $msg = null): void
    {
        $this->errmsg = $msg;
    }

    //TODO: parse method should empty the errmsg attribute before executing so that in the off chance
    // that a programmer should try to get an error message after a successful parse, it should return empty.
    // This behavior is currently implemented in each subclass individually but it would be better to enforce
    // it here in the parent class.
    abstract public function parse(string $input): bool;
}
