<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\base\text\filter_var;

use pvc\msg\Msg;
use pvc\msg\UserMsg;
use pvc\validator\base\text\filter_var\ValidatorFilterVar;

/**
 * Class ValidateFilterVarEmail
 */
class ValidatorFilterVarEmail extends ValidatorFilterVar
{
    /**
     * @var bool
     */
    protected bool $unicodeAllowed = true;

    /**
     * ValidatorFilterVarEmail constructor.
     */
    public function __construct()
    {
        $this->setFilter(FILTER_VALIDATE_EMAIL);
    }

    /**
     * @function allowUnicode
     * @param bool $flag
     * @return void
     */
    public function allowUnicode(bool $flag = true): void
    {
        $this->unicodeAllowed = $flag;
    }

    /**
     * @function isUnicodeAllowed
     * @return bool
     */
    public function isUnicodeAllowed() : bool
    {
        return $this->unicodeAllowed;
    }

    /**
     * @function setOptionsArray
     */
    protected function setOptionsArray(): void
    {
        if ($this->isUnicodeAllowed()) {
            $this->optionsArray = ['flags' => FILTER_FLAG_EMAIL_UNICODE];
        }
    }

    /**
     * @function setErrMsg
     */
    protected function setErrMsg(): void
    {
        $msgText = 'value is not a valid email address';
        $this->errmsg = new UserMsg([], $msgText);
    }
}
