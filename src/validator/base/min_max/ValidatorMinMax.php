<?php declare(strict_types = 1);

namespace pvc\validator\base\min_max;

use Carbon\Carbon;
use pvc\err\throwable\exception\pvc_exceptions\InvalidTypeException;
use pvc\err\throwable\exception\pvc_exceptions\InvalidValueException;
use pvc\err\throwable\exception\pvc_exceptions\InvalidValueMsg;
use pvc\err\throwable\exception\pvc_exceptions\UnsetAttributeException;
use pvc\err\throwable\exception\pvc_exceptions\UnsetAttributeMsg;
use pvc\formatter\FrmtrInterface;
use pvc\msg\Msg;
use pvc\msg\UserMsg;
use pvc\msg\UserMsgInterface;
use pvc\time\Time;
use pvc\validator\base\data_type\ValidatorType;
use pvc\validator\base\ValidatorInterface;

abstract class ValidatorMinMax implements ValidatorInterface
{


    /**
     * @var ValidatorType
     */
    protected ValidatorType $validatorType;

    /**
     * @var FrmtrInterface
     */
    protected FrmtrInterface $frmtr;

    /**
     * @var UserMsgInterface
     */
    protected UserMsgInterface $errmsg;

    /**
     * ValidatorMinMax constructor.
     * @param ValidatorType $validatorType
     * @param FrmtrInterface $frmtr
     */
    public function __construct(ValidatorType $validatorType, FrmtrInterface $frmtr)
    {
        $this->setValidatorType($validatorType);
        $this->setFrmtr($frmtr);
    }

    /**
     * @function setValidatorType
     * @param ValidatorType $validator
     */
    public function setValidatorType(ValidatorType $validator): void
    {
        $this->validatorType = $validator;
    }

    /**
     * @function getValidatorType
     * @return ValidatorType
     */
    public function getValidatorType(): ValidatorType
    {
        return $this->validatorType;
    }

    /**
     * @function setFrmtr
     * @param FrmtrInterface $frmtr
     */
    public function setFrmtr(FrmtrInterface $frmtr): void
    {
        $this->frmtr = $frmtr;
    }

    /**
     * @function getFrmtr
     * @return FrmtrInterface
     */
    public function getFrmtr(): FrmtrInterface
    {
        return $this->frmtr;
    }

    /**
     * @function getErrmsg
     * @return UserMsgInterface|null
     */
    public function getErrmsg(): ?UserMsgInterface
    {
        return $this->errmsg;
    }

    /**
     * @function validateMin
     * @param int|float|Carbon|Time $min
     * @throws InvalidTypeException
     * @throws InvalidValueException
     */
    public function validateMin($min): void
    {
        if (!$this->validatorType->validate($min)) {
            $errorExceptionMsg = $this->getValidatorType()->getErrMsg()->makeErrorExceptionMsg();
            throw new InvalidTypeException($errorExceptionMsg);
        }
        if (1 == $this->compareValues($min, $this->getMax())) {
            $addtlMsg = 'Min value must be less than or equal to max value.';
            $msg = new InvalidValueMsg('min', $this->frmtr->format($min), $addtlMsg);
            throw new InvalidValueException($msg);
        }
    }


    /**
     * @function validateMax
     * @param int|float|Carbon|Time $max
     * @throws InvalidTypeException
     * @throws InvalidValueException
     */
    public function validateMax($max): void
    {
        if (!$this->validatorType->validate($max)) {
            $errorExceptionMsg = $this->getValidatorType()->getErrMsg()->makeErrorExceptionMsg();
            throw new InvalidTypeException($errorExceptionMsg);
        }
        if (-1 == $this->compareValues($max, $this->getMin())) {
            $addtlMsg = 'Max value must be greater than or equal to min value.';
            $msg = new InvalidValueMsg('max', $this->frmtr->format($max), $addtlMsg);
            throw new InvalidValueException($msg);
        }
    }

    /**
     * @function validate
     * @param mixed $val
     * @return bool
     * @throws InvalidTypeException
     * @throws UnsetAttributeException
     */
    public function validate($val): bool
    {
        if (!$this->validatorType->validate($val)) {
            $msg = $this->validatorType->getErrMsg()->makeErrorExceptionMsg();
            throw new InvalidTypeException($msg);
        }
        if ($this->compareValues($this->getMin(), $val) == 1) {
            $msgVars = [$this->frmtr->format($val), $this->frmtr->format($this->getMin())];
            $msgText = "%s is less than the minimum permitted value of %s";
            $this->errmsg = new UserMsg($msgVars, $msgText);
            return false;
        }
        if ($this->compareValues($this->getMax(), $val) == -1) {
            $msgVars = [$this->frmtr->format($val), $this->frmtr->format($this->getMax())];
            $msgText = "%s is greater than the maximum permitted value of %s";
            $this->errmsg = new UserMsg($msgVars, $msgText);
            return false;
        }
        return true;
    }

    /**
     * returns -1 if a is less than b, 0 if they are equal, 1 if a > b
     *
     * under many circumstances this is just the spaceship operator but for a select few classes (time and text)
     * we need some other behaviors
     *
     * @function compareValues
     * @param mixed $a
     * @param mixed $b
     * @return int
     */
    abstract public function compareValues($a, $b): int;

    /**
     * @function setMin
     * @param mixed $min
     */
    abstract public function setMin($min) : void;

    /**
     * @function getMin
     * @return mixed
     */
    abstract public function getMin();

    /**
     * @function setMax
     * @param mixed $max
     */
    abstract public function setMax($max) : void;
    /**
     * @function getMax
     * @return mixed
     */
    abstract public function getMax();
}
