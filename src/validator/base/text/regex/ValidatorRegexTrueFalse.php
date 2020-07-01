<?php
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version 1.0
 */

namespace pvc\validator\base\text\regex;


use pvc\regex\alternation\RegexTrueFalse;

/**
 * Class ValidatorRegexTrueFalse
 * @package pvc\validator\base\text\regex
 */
class ValidatorRegexTrueFalse extends ValidatorRegex
{
    public function __construct()
    {
        $regex = new RegexTrueFalse();
        parent::__construct($regex);
    }
}