<?php declare(strict_types = 1);

namespace pvc\validator\base\text\regex;

use pvc\regex\text_ascii\RegexAlphaNumeric;
use pvc\validator\base\text\regex\ValidatorRegex;

/**
 * Class ValidatorRegexAsciiLettersNumbers
 */
class ValidatorRegexAsciiLettersNumbers extends ValidatorRegex
{

    /**
     * ValidatorRegexAsciiLettersNumbers constructor.
     * @throws \pvc\err\throwable\exception\pvc_exceptions\UnsetAttributeException
     */
    public function __construct()
    {
        parent::__construct(new RegexAlphaNumeric());
    }
}
