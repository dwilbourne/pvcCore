<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\base;

use ArrayIterator;
use pvc\msg\Msg;
use pvc\msg\MsgInterface;
use pvc\msg\UserMsg;
use pvc\msg\UserMsgInterface;
use pvc\validator\base\data_type\ValidatorType;
use pvc\validator\base\required\ValidatorNotEmptyMsg;

/**
 * Class Validator
 */
class Validator implements ValidatorInterface
{
    /**
     * @var bool
     */
    protected bool $required;

    /**
     * @var array
     */
    protected array $validatorArray = [];

    /**
     * @var UserMsgInterface
     */
    protected UserMsgInterface $errmsg;

    /**
     * Validator constructor.
     * @param ValidatorType $vt
     * @param bool $required
     */
    public function __construct(ValidatorType $vt, bool $required = true)
    {
        $this->required = $required;
        $this->push($vt);
    }

    /**
     * @function push
     * @param ValidatorInterface $validator
     */
    public function push(ValidatorInterface $validator): void
    {
        $this->validatorArray[] = $validator;
    }

    /**
     * @function getValidatorArray
     * @return array
     */
    public function getValidatorArray(): array
    {
        return $this->validatorArray;
    }

    /**
     * @function isRequired
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->required;
    }

    /**
     * @function setRequired
     * @param bool $required
     */
    public function setRequired(bool $required = true): void
    {
        $this->required = $required;
    }

    /**
     * @function getErrMsg
     * @return UserMsgInterface|null
     */
    public function getErrMsg(): ?UserMsgInterface
    {
        return $this->errmsg ?? null;
    }

    /**
     * @function validate
     * @param mixed $value
     * @return bool
     */
    public function validate($value): bool
    {
        if (is_null($value) && !$this->isRequired()) {
            return true;
        }

        if (is_null($value) && $this->isRequired()) {
            $this->errmsg = new ValidatorNotEmptyMsg();
            return false;
        }

        foreach ($this->validatorArray as $validator) {
            if (!$validator->validate($value)) {
                $this->errmsg = $validator->getErrmsg();
                return false;
            }
        }
        return true;
    }
}
