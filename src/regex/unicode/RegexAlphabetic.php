<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\regex\unicode;

use pvc\regex\Regex;

/**
 * Class RegexAlphabetic
 */
class RegexAlphabetic extends Regex
{

    /**
     * RegexAlphabetic constructor.
     *
     * we want letters represented as a single code point as well as letters modified by trailing
     * combining marks.  So we verify that the first letter in the subpattern is a letter and that
     * when the remaining code points in the subpattern are marks.
     *
     */
    public function __construct()
    {
        $this->setLabel("alphabetic text (only letters)");
        $pattern = self::PATTERN_DELIMITER . '^(\p{L}\p{M}*)*$' . self::PATTERN_DELIMITER . 'u';
        $this->setPattern($pattern);
    }
}
