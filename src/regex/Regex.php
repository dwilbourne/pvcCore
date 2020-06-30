<?php declare(strict_types = 1);

namespace pvc\regex;

use pvc\msg\Msg;
use pvc\msg\UserMsg;
use pvc\msg\UserMsgInterface;
use pvc\regex\err\RegexBadPatternException;
use pvc\regex\err\RegexInvalidMatchIndexException;
use pvc\regex\err\RegexPatternUnsetException;
use pvc\regex\err\RegexSanitizeCharException;
use Throwable;

/**
 *
 * @class Regex
 *
 * Object that wraps preg_match
 *
 */

class Regex
{

    /**
     * it's a good idea to use this wherever possible so that when preg_quote is called, you can feed this
     * constant in as the second argument.  It's not necessary to use it, of course, but if you do there's less
     * thinking involved.
     */
    public const PATTERN_DELIMITER = '/';

    /**
     * Regex pattern to be used in trying to match the subject
     *
     * @var string $pattern
     *
     */

    protected string $pattern;

    /**
     * Characters that need to be escaped if they are so be used in a regex.
     *
     * @var array $metaCharacters
     *
     */

    protected static array $metaCharacters = ['\\', '^', '$', '.', '[', ']', '|', '(', ')', '?', '*', '+', '{', '}'];

    /**
     * Characters that need to be escaped if part of a character class
     *
     * @var array $characterClassMetaCharacters
     *
     * TODO further test of what characters need to be escaped when part of a character class
     * period (".") and front slash ("/" (or whatever you are using as a delimiter?) - need to test)
     * also need to be escaped in addition to the standard metacharacters, despite whatever the documentation says...?
     */

    protected static array $characterClassMetaCharacters = ['\\', '^', '.', '-'];


    /**
     *
     * Array that holds the captured pieces of the subject.
     * The matches array is not settable externally - it can only be populated as a result of
     * running the match method in this class.
     *
     * @var array $matches
     *
     */

    protected array $matches = [];


    protected UserMsgInterface $errmsg;

    /**
     * @var string $label .  Label identifying the type of thing the regex is searching for.
     */

    protected string $label;

    /**
     *
     * @function setPattern();
     *
     * sets a regex pattern
     *
     * @param string $pattern .
     *
     * @return void
     * @throws RegexBadPatternException
     */

    public function setPattern(string $pattern): void
    {
        if (!$this->validatePattern($pattern)) {
            throw new RegexBadPatternException();
        } else {
            $this->pattern = $pattern;
        }
    }

    /**
     *
     * @function getPattern();
     *
     * gets the regex pattern
     *
     * @returns string;
     *
     */

    public function getPattern():? string
    {
        return $this->pattern ?? null;
    }

    /**
     * @function getLabel
     * @return string
     */
    public function getLabel():? string
    {
        return $this->label ?? null;
    }

    /**
     * @function setLabel
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    /**
     * @function getMatch()
     *
     * $index can be numeric or a string depending on whether you used a named subpattern or not.
     * @param int|string $index
     *
     * returns false if there is no such index set, returns a string if the $matchAll property is false
     * otherwise returns an array
     * @return string|array|false
     *
     * @throws RegexInvalidMatchIndexException
     */

    public function getMatch($index)
    {
        if (!isset($this->matches[$index])) {
            throw new RegexInvalidMatchIndexException($index);
        }
        return $this->matches[$index];
    }

    /**
     * @function getMatches()
     *
     * @return array
     *
     */

    public function getMatches(): array
    {
        return $this->matches;
    }


    /**
     * @function validatePattern
     * @param string $pattern
     * @return bool
     * validates a regex pattern.
     */
    public function validatePattern(string $pattern): bool
    {
        // preg_match outputs an error (severity = warning) and returns FALSE if it fails.
        try {
            preg_match($pattern, '');
            return true;
        } catch (Throwable $e) {
            $msg = new UserMsg([], $e->getMessage());
            $this->setErrmsg($msg);
            return false;
        }
    }

    /**
     * @function validateDelimiter
     * @param string $delimiter
     * @return bool
     *
     * delimiter must be a single char, not alphanumeric, not whitespace and not a backslash
     */
    public function validateDelimiter(string $delimiter): bool
    {
        return !((strlen($delimiter) > 1) || (ctype_alnum($delimiter)) || ('\\' == $delimiter) || (ctype_space(
            $delimiter
        )));
    }

    /**
     * @function sanitizeChar
     * @param string $char
     * @param bool $inCharacterClass
     * @return string
     * @throws RegexSanitizeCharException
     */

    public static function escapeChar(string $char, bool $inCharacterClass = false)
    {
        $array = $inCharacterClass ? self::$characterClassMetaCharacters : self::$metaCharacters;

        // don't think multibyte string verbs are necessary - all chars that need to be escaped are
        // in the ascii range anyway
        if (strlen($char) > 1) {
            throw new RegexSanitizeCharException($char);
        }

        return (in_array($char, $array)) ? '\\' . $char : $char;
    }

    /**
     * @function escapeString
     * @param string $string
     * @param bool $inCharacterClass
     * @return string
     * @throws RegexSanitizeCharException
     *
     * This method escapes all the meta characters in a string.
     */
    public static function escapeString(string $string, bool $inCharacterClass = false) : string
    {

        // don't think multibyte string verbs are necessary - all meta chars are
        // in the ascii range anyway
        $subject = str_split($string);
        $z = "";
        foreach ($subject as $char) {
            $z .= self::escapeChar($char, $inCharacterClass);
        }
        return $z;
    }

    public function getErrmsg(): UserMsgInterface
    {
        return $this->errmsg;
    }

    /**
     * @function setErrmsg
     * @param UserMsgInterface $msg
     */
    protected function setErrmsg(UserMsgInterface $msg) : void
    {
        $this->errmsg = $msg;
    }

    /**
     * @function createErrmsg string.  Creates a basic error message.
     *
     * @return UserMsg .
     */

    public function createErrmsg() : UserMsg
    {
        $msgText = '';

        if (!empty($this->label)) {
            $msgText .= 'Input must be ';

            if (in_array($this->label[0], ['a', 'e', 'i', 'o', 'u'])) {
                $msgText .= 'an ';
            } else {
                $msgText .= 'a ';
            }
            $msgText .= '%s.';
        }
        return new UserMsg([$this->getLabel()], $msgText);
    }


    /**
     * All Regex classes use this method in order to test whether a given subject matches the pattern.
     *
     * @function match bool.
     *
     * @param string $subject
     *
     * $matchAll toggles the preg_match_all verb, meaning that all matches are returned, not just the first one.
     * @param bool $matchAll
     *
     * @return bool.  Returns true or false, throws an error if preg_match throws an error.
     * @throws RegexPatternUnsetException
     */

    public function match(string $subject, bool $matchAll = false): bool
    {
        if (!isset($this->pattern)) {
            throw new RegexPatternUnsetException();
        }

        if ($matchAll) {
            $result = preg_match_all($this->pattern, $subject, $this->matches);
        } else {
            $result = preg_match($this->pattern, $subject, $this->matches);
        }

        // $result should never be false because pattern was validated when setting the pattern

        if ($result == 0) {
            $this->errmsg = $this->createErrmsg();
            return false;
        }
        return true;
    }
}
