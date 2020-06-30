<?php declare(strict_types = 1);

namespace pvc\regex\windows;

use pvc\regex\Regex;

/**
 * Class RegexWindowsFilename
 *
 * Documentation for windows file names can be found at
 * https://docs.microsoft.com/en-us/windows/desktop/FileIO/naming-a-file
 */
class RegexWindowsFilename extends Regex
{
    public function __construct(bool $allowFileExtension = true)
    {
        // illegal filenames are coded as a series of case-insensitive negative lookahead assertions
        // first bracket each filename with begin / end of subject
        $badFileNames = [];
        foreach ($this->getIllegalFilenames() as $filename) {
            $badFileNames[] = '^' . $filename . '$';
        }

        $pattern = '';
        $pattern .= self::PATTERN_DELIMITER . '^(?!(?i)(' . implode('|', $badFileNames) . '))';

        // illegal characters are coded as a negative character class.  The max number of characters in
        // a filename is, I think, 256.
        $pattern .= "[^" . $this->getIllegalChars($allowFileExtension) . "]{1,256}";

        // assert end of subject / end of pattern
        $pattern .= '$' . self::PATTERN_DELIMITER;

        $this->setPattern($pattern);
    }

    private function getIllegalFilenames(): array
    {
        $illegalFilenames = [];
        $illegalFilenames[] = 'CON';
        $illegalFilenames[] = 'PRN';
        $illegalFilenames[] = 'AUX';
        $illegalFilenames[] = 'NUL';
        for ($i = 1; $i < 10; $i++) {
            $illegalFilenames[] = 'COM' . $i;
            $illegalFilenames[] = 'LPT' . $i;
        }
        return $illegalFilenames;
    }

    // the following chars are illegal: < > : " \ / | ? *
    private function getIllegalChars(bool $allowFileExtension): string
    {
        $result = '<>:"\/|?*';
        if (!$allowFileExtension) {
            $result .= '.';
        }
        return preg_quote($result, self::PATTERN_DELIMITER);
    }
}
