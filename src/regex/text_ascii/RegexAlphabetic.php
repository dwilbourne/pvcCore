<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\regex\text_ascii;

use pvc\regex\Regex;

/**
 * Class RegexAlphabetic
 */
class RegexAlphabetic extends Regex
{
    public function __construct()
    {
        $this->setLabel("alphabetic text (only letters)");
        // having trouble with POSIX notation on my system - gives a compile error....
        // $pattern = '/^[:alpha:]*$/';
        $pattern = self::PATTERN_DELIMITER . '^[a-zA-Z]*$' . self::PATTERN_DELIMITER;
        $this->setPattern($pattern);
    }
}
