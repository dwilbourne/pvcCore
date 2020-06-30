<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\regex\text_ascii;

use pvc\regex\Regex;

/**
 * Class RegexTextAlphaNumeric
 */
class RegexAlphaNumeric extends Regex
{
    public function __construct()
    {
        $this->setLabel("alphanumeric text (only letters and numbers)");
        // having trouble with POSIX notation on my system - gives a compile error....
        // $pattern = '/^[:alnum:]*$/';
        $pattern = self::PATTERN_DELIMITER . '^[a-zA-Z0-9]*$' . self::PATTERN_DELIMITER;
        $this->setPattern($pattern);
    }
}
