<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\base\text\regex;

use pvc\regex\windows\RegexWindowsFilename;
use pvc\validator\base\text\regex\ValidatorRegex;

/**
 * Class ValidatorRegexWindowsFilename
 */
class ValidatorRegexWindowsFilename extends ValidatorRegex
{
    /**
     * ValidatorRegexWindowsFilename constructor.
     * @param bool $allowWindowsFilename
     * @throws \pvc\err\throwable\exception\pvc_exceptions\UnsetAttributeException
     */
    public function __construct(bool $allowWindowsFilename = true)
    {
        $regex = new RegexWindowsFilename($allowWindowsFilename);
        parent::__construct($regex);
    }
}
