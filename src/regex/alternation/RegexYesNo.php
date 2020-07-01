<?php
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version 1.0
 */

namespace pvc\regex\alternation;


/**
 * Class RegexYesNo
 * @package pvc\regex\alternation
 */
class RegexYesNo extends RegexAlternationSimple
{

    public function __construct()
    {
        $this->setLabel("yes / no (not case sensitive)");
        $this->addChoice('yes');
        $this->addChoice('no');
        $this->setCaseSensitive(false);
        $this->setPattern($this->makePattern());
    }
}