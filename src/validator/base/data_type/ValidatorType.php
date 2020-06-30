<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\base\data_type;

use pvc\msg\UserMsg;
use pvc\validator\base\data_type\err\ValidatorTypeMsg;
use pvc\validator\base\ValidatorInterface;

/**
 * Class ValidatorType
 */
abstract class ValidatorType implements ValidatorInterface
{
    /**
     * @var string
     */
    protected string $dataType;

    /**
     * @var UserMsg
     */
    protected UserMsg $errmsg;

    /**
     * ValidatorType constructor.
     * @param string $type
     */
    public function __construct(string $type)
    {
        $this->setDataType($type);
    }

    /**
     * @function getDataType
     * @return string
     */
    public function getDataType(): string
    {
        return $this->dataType;
    }

    /**
     * @function setDataType
     * @param string $dataType
     */
    public function setDataType(string $dataType): void
    {
        $this->dataType = $dataType;
    }

    /**
     * @function validate
     * @param mixed $value
     * @return bool
     */
    public function validate($value): bool
    {
        if (!$this->validateType($value)) {
            $this->errmsg = new ValidatorTypeMsg($this->dataType);
            return false;
        }
        return true;
    }

    /**
     * @function validateType
     * @param mixed $value
     * @return bool
     */
    abstract public function validateType($value): bool;

    /**
     * @function getErrMsg
     * @return UserMsg
     */
    public function getErrMsg(): UserMsg
    {
        return $this->errmsg;
    }
}
