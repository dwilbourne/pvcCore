<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\sanitizer;

/**
 * Class SanitizerText
 */
class SanitizerText implements SanitizerInterface
{

    public function sanitize(string $string): string
    {
        // in theory filter_var can return false so there is some syntactic sugar on the end of this.
        return filter_var($string, FILTER_SANITIZE_STRING, ['flags' => FILTER_FLAG_STRIP_LOW]) ?: '';
    }
}
