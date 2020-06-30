<?php declare(strict_types = 1);

namespace pvc\validator\sys;

use pvc\validator\base\data_type\ValidatorTypeText;
use pvc\validator\base\text\filter_var\ValidatorFilterVarUrl;
use pvc\validator\base\Validator;

/**
 * Class ValidatorUrl
 */
class ValidatorUrl extends Validator
{
    /**
     * @var ValidatorFilterVarUrl
     */
    protected ValidatorFilterVarUrl $validatorUrl;

    /**
     * ValidatorUrl constructor.
     * @param bool $notNull
     */
    public function __construct($notNull = true)
    {
        $vt = new ValidatorTypeText();
        parent::__construct($vt, $notNull);

        $this->validatorUrl = new ValidatorFilterVarUrl();
        $this->push($this->validatorUrl);
    }

    /**
     * @function setPathRequired
     * @param bool $pathRequired
     */
    public function setPathRequired(bool $pathRequired = true): void
    {
        $this->validatorUrl->setPathRequired($pathRequired);
    }

    /**
     * @function setQueryRequired
     * @param bool $queryRequired
     */
    public function setQueryRequired(bool $queryRequired = true): void
    {
        $this->validatorUrl->setQueryRequired($queryRequired);
    }
}
