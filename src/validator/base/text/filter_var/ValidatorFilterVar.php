<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\base\text\filter_var;

use pvc\msg\MsgInterface;
use pvc\msg\UserMsg;
use pvc\msg\UserMsgInterface;
use pvc\validator\base\data_type\ValidatorTypeText;
use pvc\validator\base\ValidatorInterface;

/**
 * Class ValidatorText
 */
abstract class ValidatorFilterVar implements ValidatorInterface
{
    /**
     * @var int
     */
    protected int $filter;

    /**
     * @var array|null
     */
    protected ? array $optionsArray;

    /**
     * @var UserMsg
     */
    protected UserMsg $errmsg;

    /**
     * @function getFilter
     * @return int
     */
    public function getFilter(): int
    {
        return $this->filter;
    }

    /**
     * @function setFilter
     * @param int $filter
     */
    public function setFilter(int $filter): void
    {
        $this->filter = $filter;
    }

    /**
     * @function getOptionsArray
     * @return array
     */
    public function getOptionsArray(): ? array
    {
        return $this->optionsArray ?? null;
    }

    /**
     * @function validate
     * @param string $data
     * @return bool
     */
    public function validate($data): bool
    {
        $this->setOptionsArray();
        if (false === filter_var($data, $this->getFilter(), $this->getOptionsArray())) {
            $this->setErrMsg();
            return false;
        }
        return true;
    }

    /**
     * @function getErrMsg
     * @return UserMsgInterface|null
     */
    public function getErrMsg(): ?UserMsgInterface
    {
        return $this->errmsg ?? null;
    }

    abstract protected function setOptionsArray(): void;
    abstract protected function setErrMsg(): void;
}
