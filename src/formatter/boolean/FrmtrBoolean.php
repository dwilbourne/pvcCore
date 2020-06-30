<?php declare(strict_types = 1);

namespace pvc\formatter\boolean;

use pvc\formatter\boolean\err\AddBooleanFormatException;
use pvc\formatter\boolean\err\SetBooleanFormatException;
use pvc\formatter\Frmtr;
use pvc\formatter\FrmtrInterface;
use pvc\validator\base\data_type\ValidatorTypeBoolean;

/**
 * Formats a boolean value into any one of several formats.
 *
 * Class FrmtrBoolean
 */
class FrmtrBoolean extends Frmtr implements FrmtrInterface
{

    /**
     * @var array|string[]
     */
    protected array $formats;

    /**
     * FrmtrBoolean constructor.
     * @param string $format
     * @throws SetBooleanFormatException
     */
    public function __construct(string $format = 'yes')
    {
        $vt = new ValidatorTypeBoolean();
        $this->setTypeValidator($vt);
        $this->formats = $this->createFormats();
        $this->setFormat($format);
    }

    /**
     * @function setFormat
     * @param string $format
     * @throws SetBooleanFormatException
     */
    public function setFormat(string $format): void
    {
        if (!$this->validateBooleanFormat($format)) {
            throw new SetBooleanFormatException($format);
        }
        $this->format = $format;
    }

    /**
     * @function getFormat
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @function createFormats
     * @return array|string[]
     */
    protected function createFormats(): array
    {
        return [
            'yes' => 'no',
            'true' => 'false',
            '1' => '0'
        ];
    }

    /**
     * @function getFormats
     * @return string[]
     */
    public function getFormats(): array
    {
        return $this->formats;
    }

    /**
     * @function addFormat
     * @param string $trueString
     * @param string $falseString
     * @throws AddBooleanFormatException
     */
    public function addFormat(string $trueString, string $falseString): void
    {
        if ($trueString == $falseString) {
            throw new AddBooleanFormatException($trueString);
        }
        if (!isset($this->formats[$trueString])) {
            $this->formats[$trueString] = $falseString;
        }
    }

    /**
     * @function validateBooleanFormat
     * @param string $x
     * @return bool
     */
    public function validateBooleanFormat(string $x): bool
    {
        return in_array($x, array_keys($this->getFormats()));
    }

    /**
     * @function getTrueString
     * @return string
     */
    public function getTrueString(): string
    {
        return $this->format;
    }

    /**
     * @function getFalseString
     * @return string
     */
    public function getFalseString(): string
    {
        return $this->formats[$this->format];
    }

    /**
     * @function formatValue
     * @param bool $x
     * @return string
     */
    public function formatValue($x): string
    {
        return $x ? $this->getTrueString() : $this->getFalseString();
    }
}
