<?php declare(strict_types = 1);

namespace pvc\validator\base\text\regex;

use pvc\err\throwable\exception\pvc_exceptions\UnsetAttributeException;
use pvc\err\throwable\exception\pvc_exceptions\UnsetAttributeMsg;
use pvc\msg\Msg;
use pvc\msg\UserMsg;
use pvc\msg\UserMsgInterface;
use pvc\regex\Regex;
use pvc\validator\base\ValidatorInterface;

/**
 * Class ValidatorRegex
 */
abstract class ValidatorRegex implements ValidatorInterface
{

    /**
     * @var Regex
     */
    protected Regex $regex;

    /**
     * @var UserMsgInterface
     */
    protected UserMsgInterface $errmsg;

    /**
     * ValidatorRegex constructor.
     * @param Regex $regex
     * @throws UnsetAttributeException
     */
    public function __construct(Regex $regex)
    {
        $this->setRegex($regex);
    }

    /**
     * @function getRegex
     * @return Regex
     */
    public function getRegex(): Regex
    {
        return $this->regex;
    }

    /**
     * @function setRegex
     * @param Regex $regex
     * @throws UnsetAttributeException
     */
    public function setRegex(Regex $regex): void
    {
        if (is_null($regex->getPattern())) {
            $msg = new UnsetAttributeMsg('regex pattern');
            throw new UnsetAttributeException($msg);
        }
        $this->regex = $regex;
    }

    /**
     * @function getErrmsg
     * @return UserMsgInterface
     */
    public function getErrmsg(): UserMsgInterface
    {
        return $this->errmsg;
    }

    /**
     * @function setErrmsg
     * @param UserMsgInterface $errmsg
     */
    protected function setErrmsg(UserMsgInterface $errmsg): void
    {
        $this->errmsg = $errmsg;
    }

    /**
     * @function validate
     * @param string $data
     * @return bool
     * @throws \pvc\regex\err\RegexPatternUnsetException
     */
    public function validate($data) : bool
    {
        if (!$this->regex->match($data)) {
            $this->setErrmsg($this->regex->getErrmsg());
            return false;
        }
        return true;
    }
}
