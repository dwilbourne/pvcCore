<?php
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version 1.0
 */

namespace pvc\regex\alternation;

use pvc\err\throwable\exception\pvc_exceptions\OutOfContextMethodCallException;
use pvc\regex\err\RegexBadPatternException;

/**
 * Class RegexTrueFalse
 * @package pvc\regex\alternation
 */
class RegexTrueFalse extends RegexAlternationSimple
{
    /**
     * RegexTrueFalse constructor.
     * @throws OutOfContextMethodCallException
     * @throws RegexBadPatternException
     */
    public function __construct()
    {
        $this->setLabel("true / false (not case sensitive)");
        $this->addChoice('true');
        $this->addChoice('false');
        $this->setCaseSensitive(false);
        $this->setPattern($this->makePattern());
    }
}
