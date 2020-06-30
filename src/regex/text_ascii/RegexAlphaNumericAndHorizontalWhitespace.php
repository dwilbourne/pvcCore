<?php declare(strict_types = 1);

namespace pvc\regex\text_ascii;

use pvc\regex\Regex;

/**
 * Class RegexAlphaNumericAndHorizontalWhitespace
 */
class RegexAlphaNumericAndHorizontalWhitespace extends Regex
{
    public function __construct()
    {
        $this->setLabel("alphanumeric or a horizontal whitespace character");
        $pattern = self::PATTERN_DELIMITER . '^[a-zA-Z0-9\h]*$' . self::PATTERN_DELIMITER;
        $this->setPattern($pattern);
    }
}
