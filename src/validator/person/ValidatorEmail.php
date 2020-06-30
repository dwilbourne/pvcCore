<?php declare(strict_types = 1);

namespace pvc\validator\person;

use pvc\validator\base\data_type\ValidatorTypeText;
use pvc\validator\base\text\filter_var\ValidatorFilterVarEmail;
use pvc\validator\base\Validator;

/**
 * Class ValidatorEmail
 */
class ValidatorEmail extends Validator
{
    /**
     * @var ValidatorFilterVarEmail
     */
    protected ValidatorFilterVarEmail $validatorEmail;

    /**
     * ValidatorEmail constructor.
     * @param bool $notEmpty
     */
    public function __construct(bool $notEmpty = true)
    {
        $vt = new ValidatorTypeText();
        parent::__construct($vt, $notEmpty);
        $this->validatorEmail = new ValidatorFilterVarEmail();
        $this->push($this->validatorEmail);
    }

    /**
     * @function allowUnicode
     * @param bool $flag
     */
    public function allowUnicode(bool $flag = true): void
    {
        $this->validatorEmail->allowUnicode($flag);
    }
}
