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
 * Class ValidatorNotNull
 */
class ValidatorNotNull implements ValidatorInterface
{

    /**
     * @var bool
     */
    protected bool $notNull;

    /**
     * @var UserMsg
     */
    protected UserMsg $errmsg;

    /**
     * ValidatorNotNull constructor.
     * @param bool $notNull
     */
    public function __construct(bool $notNull)
    {
        $this->notNull = $notNull;
    }

    /**
     * @function validate
     * @param mixed $value
     * @return bool
     */
    public function validate($value) : bool
    {
        if (is_null($value) && $this->notNull) {
            $this->errmsg = new ValidatorNotNullMsg();
            return false;
        }
        return true;
    }

    /**
     * @function getErrMsg
     * @return UserMsg|null
     */
    public function getErrMsg(): ? UserMsg
    {
        return $this->errmsg ?? null;
    }
}
