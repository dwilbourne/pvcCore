<?php declare(strict_types = 1);

namespace pvc\formatter;

use pvc\err\throwable\exception\pvc_exceptions\InvalidTypeException;
use pvc\msg\ErrorExceptionMsg;
use pvc\validator\base\data_type\ValidatorType;

/**
 * parent class to all the pvc formatter classes.
 *
 * Class Frmtr
 *
 */
abstract class Frmtr implements FrmtrInterface
{

    /**
     * @var string
     */
    protected string $format;

    /**
     * @var ValidatorType
     */
    protected ValidatorType $typeValidator;

    /**
     * @function getFormat
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @function setFormat
     * @param string $format
     */
    public function setFormat(string $format): void
    {
        $this->format = $format;
    }

    /**
     * @function format
     * @param mixed $x
     * @return string
     * @throws InvalidTypeException
     */
    public function format($x): string
    {
        if (!$this->getTypeValidator()->validate($x)) {
            $msgVars = [$this->getTypeValidator()->getDataType(), gettype($x)];
            $msgText = 'Argument to format must be of type %s: argument supplied was of type %s';
            $msg = new ErrorExceptionMsg($msgVars, $msgText);
            throw new InvalidTypeException($msg);
        }
        return $this->formatValue($x);
    }

    /**
     * @function getTypeValidator
     * @return ValidatorType
     */
    public function getTypeValidator(): ValidatorType
    {
        return $this->typeValidator;
    }

    /**
     * @function setTypeValidator
     * @param ValidatorType $typeValidator
     */
    public function setTypeValidator(ValidatorType $typeValidator): void
    {
        $this->typeValidator = $typeValidator;
    }

    /**
     * @function formatValue
     * @param mixed $value
     * @return string
     */
    abstract protected function formatValue($value): string;
}
