<?php declare(strict_types = 1);

namespace pvc\validator\base;

use pvc\msg\UserMsgInterface;

interface ValidatorInterface
{
    /**
     * @function validate
     * @param mixed $data
     * @return bool
     */
    public function validate($data): bool;

    /**
     * @function getErrMsg
     * @return UserMsgInterface|null
     */
    public function getErrMsg(): ?UserMsgInterface;
}
