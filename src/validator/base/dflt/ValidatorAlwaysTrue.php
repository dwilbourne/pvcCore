<?php
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version 1.0
 */

namespace pvc\validator\base\dflt;

use pvc\msg\UserMsgInterface;
use pvc\validator\base\ValidatorInterface;

/**
 * Class ValidatorAlwaysTrue
 * @package pvc\validator\base\dflt
 */
class ValidatorAlwaysTrue implements ValidatorInterface
{
    public function validate($data = null): bool
    {
        return true;
    }

    public function getErrMsg(): ?UserMsgInterface
    {
        return null;
    }
}
