<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\base\required;

use pvc\msg\Msg;
use pvc\msg\UserMsg;
use pvc\validator\base\ValidatorInterface;

/**
 * Class ValidatorNotEmpty
 */
class ValidatorNotEmpty implements ValidatorInterface
{
    /**
     * @var bool
     */
    protected bool $notEmpty;

    /**
     * @var UserMsg
     */
    protected UserMsg $errmsg;

    /**
     * ValidatorNotEmpty constructor.
     * @param bool $notEmpty
     */
    public function __construct(bool $notEmpty)
    {
        $this->notEmpty = $notEmpty;
    }

    /**
     * @function validate
     * @param mixed $value
     * @return bool
     */
    public function validate($value) : bool
    {
        if (empty($value) && $this->notEmpty) {
            $this->errmsg = new ValidatorNotEmptyMsg();
            return false;
        }
        return true;
    }

    /**
     * @function getErrMsg
     * @return UserMsg|null
     */
    public function getErrMsg(): ?UserMsg
    {
        return $this->errmsg ?? null;
    }
}
