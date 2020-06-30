<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\sys;

use pvc\msg\UserMsg;
use pvc\validator\base\ValidatorInterface;

/**
 * Class ValidatorArrayKey
 */
class ValidatorArrayKey implements ValidatorInterface
{
    /**
     * @var bool
     */
    protected bool $allowNullKey;

    /**
     * @var UserMsg
     */
    protected UserMsg $errmsg;

    /**
     * ValidatorArrayKey constructor.
     * @param bool $allowNullKey
     */
    public function __construct(bool $allowNullKey = false)
    {
        $this->allowNullKey($allowNullKey);
    }

    /**
     * @function allowNullKey
     * @param bool $value
     */
    public function allowNullKey(bool $value = true) : void
    {
        $this->allowNullKey = $value;
    }

    /**
     * @function nullKeyIsAllowed
     * @return bool
     */
    public function nullKeyIsAllowed(): bool
    {
        return $this->allowNullKey;
    }

    /**
     * @function validate
     * @param int|string|null $key
     * @return bool
     */
    public function validate($key): bool
    {
        if ($this->allowNullKey && is_null($key)) {
            return true;
        }
        if (is_string($key) || is_int($key)) {
            return true;
        } else {
            $suffix = $this->allowNullKey ? ' or null' : '';
            $msgText = 'key must be either an integer or a string' . $suffix . '.';
            $this->errmsg = new UserMsg([], $msgText);
        }
        return false;
    }

    /**
     * @function getErrMsg
     * @return UserMsg|null
     */
    public function getErrMsg(): ?UserMsg
    {
        return $this->errmsg;
    }
}
