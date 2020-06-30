<?php declare(strict_types = 1);

namespace pvc\validator\base\min_max;

use pvc\err\throwable\exception\pvc_exceptions\InvalidTypeException;
use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentException;
use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentMsg;
use pvc\formatter\numeric\FrmtrInteger;
use pvc\formatter\text\FrmtrText;
use pvc\msg\ErrorExceptionMsg;
use pvc\msg\UserMsg;
use pvc\validator\base\data_type\ValidatorTypeInteger;
use pvc\validator\base\data_type\ValidatorTypeText;

/**
 * Class ValidatorMinMaxText
 */
class ValidatorMinMaxText extends ValidatorMinMax
{

    /**
     * @var int
     */
    protected int $min;

    /**
     * @var int
     */
    protected int $max;

    public function __construct(int $min = 0, int $max = PHP_INT_MAX)
    {
        $vt = new ValidatorTypeInteger();
        $frmtr = new FrmtrInteger();
        parent::__construct($vt, $frmtr);
        $this->setMin($min);
        $this->setMax($max);
    }

    /**
     * @function setMin
     * @param int $min
     * @throws \pvc\err\throwable\exception\pvc_exceptions\InvalidTypeException
     * @throws \pvc\err\throwable\exception\pvc_exceptions\InvalidValueException
     */
    public function setMin($min) : void
    {
        if ($min < 0) {
            $msg = new InvalidArgumentMsg('int >= 0');
            throw new InvalidArgumentException($msg);
        }
        $this->validateMin($min);
        $this->min = $min;
    }

    /**
     * @function getMin
     * @return int
     */
    public function getMin() : int
    {
        return $this->min ?? 0;
    }

    /**
     * @function setMax
     * @param int $max
     * @throws \pvc\err\throwable\exception\pvc_exceptions\InvalidTypeException
     * @throws \pvc\err\throwable\exception\pvc_exceptions\InvalidValueException
     */
    public function setMax($max) : void
    {

        $this->validateMax($max);
        $this->max = $max;
    }

    /**
     * @function getMax
     * @return int
     */
    public function getMax() : int
    {
        return $this->max ?? PHP_INT_MAX;
    }

    /**
     * @function validate
     * @param string $val
     * @return bool
     * @throws InvalidTypeException
     */
    public function validate($val): bool
    {
        if (!is_string($val)) {
            $msgText = 'Argument to validate must be of type string';
            $msg = new ErrorExceptionMsg([], $msgText);
            throw new InvalidTypeException($msg);
        }
        if ($this->compareValues($this->min, strlen($val)) == 1) {
            $msgVars = [$this->frmtr->format($this->min)];
            $msgText = "The number of characters in the argument is less than the minimum permitted value of %s";
            $this->errmsg = new UserMsg($msgVars, $msgText);
            return false;
        }
        if ($this->compareValues($this->max, strlen($val)) == -1) {
            $msgVars = [$this->frmtr->format($this->max)];
            $msgText = "The number of characters in the argument is greater than the maximum permitted value of %s";
            $this->errmsg = new UserMsg($msgVars, $msgText);
            return false;
        }
        return true;
    }

    /**
     * @function compareValues
     * @param int $a
     * @param int $b
     * @return int
     */
    public function compareValues($a, $b): int
    {
        return $a <=> $b;
    }
}
