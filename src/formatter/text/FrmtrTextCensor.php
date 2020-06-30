<?php declare(strict_types = 1);

namespace pvc\formatter\text;

use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentException;
use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentMsg;
use pvc\formatter\FrmtrInterface;
use pvc\formatter\text\err\FrmtrTextCensorException;
use pvc\formatter\text\err\FrmtrTextCensorMsg;

/**
 * Class FrmtrTextCensor
 */
class FrmtrTextCensor implements FrmtrInterface
{

    /**
     * @var int
     */
    protected int $firstCharsDisplayed = 0;

    /**
     * @var int
     */
    protected int $lastCharsDisplayed = 0;

    /**
     * @var string
     */
    protected string $replacementChars = '*';

    /**
     * @function getFirstCharsDisplayed
     * @return int
     */
    public function getFirstCharsDisplayed(): int
    {
        return $this->firstCharsDisplayed;
    }

    /**
     * @function setFirstCharsDisplayed
     * @param int $firstCharsDisplayed
     * @throws FrmtrTextCensorException
     */
    public function setFirstCharsDisplayed(int $firstCharsDisplayed): void
    {
        if ($firstCharsDisplayed < 0) {
            $msg = new FrmtrTextCensorMsg('firstCharsDisplayed', $firstCharsDisplayed);
            throw new FrmtrTextCensorException($msg);
        }
        $this->firstCharsDisplayed = $firstCharsDisplayed;
    }

    /**
     * @function getLastCharsDisplayed
     * @return int
     */
    public function getLastCharsDisplayed(): int
    {
        return $this->lastCharsDisplayed;
    }

    /**
     * @function setLastCharsDisplayed
     * @param int $lastCharsDisplayed
     * @throws FrmtrTextCensorException
     */
    public function setLastCharsDisplayed(int $lastCharsDisplayed): void
    {
        if ($lastCharsDisplayed < 0) {
            $msg = new FrmtrTextCensorMsg('lastCharsDisplayed', $lastCharsDisplayed);
            throw new FrmtrTextCensorException($msg);
        }
        $this->lastCharsDisplayed = $lastCharsDisplayed;
    }

    /**
     * @function getReplacementChars
     * @return string
     */
    public function getReplacementChars(): string
    {
        return $this->replacementChars;
    }

    /**
     * given the intent of the class, it seems reasonable to restrict the chars in the replacementChars string
     * to basic printable (non-whitespace) chars in the 7 bit ascii range.
     *
     * @function setReplacementChars
     * @param string $replacementChars
     */
    public function setReplacementChars(string $replacementChars): void
    {
        $this->replacementChars = $replacementChars;
    }


    /**
     * @function format
     * @param mixed $subject
     * @return string
     * @throws InvalidArgumentException
     */
    public function format($subject): string
    {
        if (!is_string($subject)) {
            $msg = new InvalidArgumentMsg('string');
            throw new InvalidArgumentException($msg);
        }

        $padAmt = strlen($subject) - $this->getFirstCharsDisplayed() - $this->getLastCharsDisplayed();

        if ($padAmt <= 0) {
            return $subject;
        }

        $firstPortion = substr($subject, 0, $this->getFirstCharsDisplayed());
        $lastPortion = substr($subject, 0, -1 * $this->getLastCharsDisplayed());

        return str_pad($firstPortion, $padAmt, $this->getReplacementChars(), STR_PAD_RIGHT) . $lastPortion;
    }
}
