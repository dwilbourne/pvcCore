<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\sanitizer;

/**
 * Class SanitizerHtml
 */
class SanitizerHtml implements SanitizerInterface
{

    public function sanitize(string $string) : string
    {
        return htmlspecialchars($string, ENT_QUOTES);
    }
}
