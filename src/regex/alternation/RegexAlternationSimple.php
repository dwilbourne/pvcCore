<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\regex\alternation;

use pvc\err\throwable\exception\pvc_exceptions\OutOfContextMethodCallException;
use pvc\msg\ErrorExceptionMsg;
use pvc\Regex\Regex;

/**
 * Class RegexAlternationSimple
 */

class RegexAlternationSimple extends Regex
{
    protected array $choices;

    protected bool $caseSensitive;



    public function addChoice(string $choice)
    {
        $this->choices[] = $choice;
    }

    public function setCaseSensitive(bool $x)
    {
        $this->caseSensitive = $x;
    }

    public function makePattern(): string
    {
        if (empty($this->choices)) {
            $msgText = 'No choices have been configured.';
            $msg = new ErrorExceptionMsg([], $msgText);
            throw new OutOfContextMethodCallException($msg);
        }

        $y = '(';
        foreach ($this->choices as $choice) {
            $y .= $choice . '|';
        }
        $y = substr($y, 0, -1);
        $y .= ')';

        $z = '';
        $z .= Regex::PATTERN_DELIMITER . '^';
        $z .= $y;
        $z .= '$' . Regex::PATTERN_DELIMITER;

        $z .= (!$this->caseSensitive ? 'i' : '');
        return $z;
    }
}
