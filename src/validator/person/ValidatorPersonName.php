<?php declare(strict_types = 1);

namespace pvc\validator\person;

use pvc\validator\base\data_type\ValidatorTypeText;
use pvc\validator\base\min_max\ValidatorMinMaxText;
use pvc\validator\base\Validator;

/**
 * Class ValidatorPersonName
 */
class ValidatorPersonName extends Validator
{
    /**
     * ValidatorPersonName constructor.
     * @param bool $notEmpty
     */
    public function __construct(bool $notEmpty = true)
    {
        $vt = new ValidatorTypeText();
        parent::__construct($vt, $notEmpty);

        $minLength = 2;
        $maxLength = 100;
        $mm = new ValidatorMinMaxText($minLength, $maxLength);
        $this->push($mm);
    }
}
