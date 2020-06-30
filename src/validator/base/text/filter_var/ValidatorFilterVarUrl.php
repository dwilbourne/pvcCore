<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\base\text\filter_var;

use pvc\msg\Msg;
use pvc\msg\UserMsg;
use pvc\validator\base\data_type\ValidatorTypeText;
use pvc\validator\base\text\filter_var\ValidatorFilterVar;

/**
 * Class ValidatorFilterVarUrl
 */
class ValidatorFilterVarUrl extends ValidatorFilterVar
{
    /**
     * @var bool
     */
    protected bool $pathRequired = false;

    /**
     * @var bool
     */
    protected bool $queryRequired = false;

    /**
     * ValidatorFilterVarUrl constructor.
     */
    public function __construct()
    {
        $this->setFilter(FILTER_VALIDATE_URL);
    }

    /**
     * @function isPathRequired
     * @return bool
     */
    public function isPathRequired(): bool
    {
        return $this->pathRequired;
    }

    /**
     * @function setPathRequired
     * @param bool $pathRequired
     */
    public function setPathRequired(bool $pathRequired = true): void
    {
        $this->pathRequired = $pathRequired;
    }

    /**
     * @function isQueryRequired
     * @return bool
     */
    public function isQueryRequired(): bool
    {
        return $this->queryRequired;
    }

    /**
     * @function setQueryRequired
     * @param bool $queryRequired
     */
    public function setQueryRequired(bool $queryRequired = true): void
    {
        $this->queryRequired = $queryRequired;
    }

    /**
     * @function setErrMsg
     */
    protected function setErrMsg(): void
    {
        $msgText = 'value is not a valid URL';
        $this->errmsg = new UserMsg([], $msgText);
    }

    /**
     * @function setOptionsArray
     */
    protected function setOptionsArray() : void
    {
        $flags = 0;
        $flags = $flags | ($this->pathRequired ? FILTER_FLAG_PATH_REQUIRED : 0);
        $flags = $flags | ($this->queryRequired ? FILTER_FLAG_QUERY_REQUIRED : 0);
        if ($flags != 0) {
            $this->optionsArray = ['flags' => $flags];
        }
    }
}
