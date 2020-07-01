<?php
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version 1.0
 */

namespace pvc\regex\text_ascii;

use pvc\regex\Regex;

/**
 * Class RegexVisibleCharsPlusHorizontalWhitespace
 * @package pvc\regex\text_ascii
 */
class RegexVisibleCharsPlusHorizontalWhitespace extends Regex
{
    public function __construct()
    {
        $this->setLabel("visible (printable) chars plus horizontal whitespace chars");
        $pattern = self::PATTERN_DELIMITER . '^[ -~\h]*$' . self::PATTERN_DELIMITER;
        $this->setPattern($pattern);
    }
}
