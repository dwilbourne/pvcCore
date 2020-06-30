<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\sys;

use pvc\validator\base\Validator;
use pvc\validator\base\data_type\ValidatorTypeText;
use pvc\validator\base\min_max\ValidatorMinMaxText;
use pvc\validator\base\text\regex\ValidatorRegexAsciiLettersNumbers;
use pvc\validator\base\ValidatorInterface;

/**
 * Class ValidatorAsciiLettersNumbers
 */
class ValidatorAsciiLettersNumbers extends Validator implements ValidatorInterface
{
    /**
     * ValidatorAsciiLettersNumbers constructor.
     * @param int $minLength
     * @param int $maxLength
     * @param bool $required
     * @throws \pvc\err\throwable\exception\pvc_exceptions\InvalidTypeException
     * @throws \pvc\err\throwable\exception\pvc_exceptions\InvalidValueException
     */
    public function __construct(int $minLength = 1, int $maxLength = 256, bool $required = true)
    {
        $vt = new ValidatorTypeText();
        parent::__construct($vt, $required);

        // newer versions of Windows might allow filenames > 256 chars but let's be real here....
        $validatorText = new ValidatorMinMaxText($minLength, $maxLength);
        $this->push($validatorText);

        $validatorRegex = new ValidatorRegexAsciiLettersNumbers();
        $this->push($validatorRegex);
    }
}
