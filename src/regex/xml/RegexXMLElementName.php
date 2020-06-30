<?php declare(strict_types = 1);

namespace pvc\regex\xml;

use pvc\regex\Regex;

/**
 * Class RegexXMLElementName
 */
class RegexXMLElementName extends Regex
{
    public function __construct()
    {
        $this->setLabel("XMLElementName");

        // use a look-ahead negative assertion so no characters are consumed, case-insensitive match
        $pat_cannot_start_with_xml = '(?!(?i)xml)';

        $pat_first_character_must_be_alpha = '[a-zA-Z]';

        // "word" characters plus hyphen, period
        $pat_contains_only_letters_digits_underscores_hyphens_periods_and_no_whitespace = "[\w\-\.]*";

        $z = "";
        $z .= self::PATTERN_DELIMITER . '^';
        $z .= $pat_cannot_start_with_xml;
        $z .= $pat_first_character_must_be_alpha;
        $z .= $pat_contains_only_letters_digits_underscores_hyphens_periods_and_no_whitespace;
        $z .= '$' . self::PATTERN_DELIMITER;
        $this->setPattern($z);
    }
}
