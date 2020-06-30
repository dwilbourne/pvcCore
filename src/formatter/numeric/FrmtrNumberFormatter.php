<?php declare(strict_types = 1);

namespace pvc\formatter\numeric;

use NumberFormatter;
use pvc\formatter\Frmtr;
use pvc\formatter\FrmtrInterface;

abstract class FrmtrNumberFormatter extends Frmtr implements FrmtrInterface
{
    protected NumberFormatter $frmtr;


    /**
     * @function setFormatter
     * @param NumberFormatter $frmtr
     */
    public function setFormatter(NumberFormatter $frmtr) : void
    {
        $this->frmtr = $frmtr;
    }

    /**
     * @function getFormatter
     * @return NumberFormatter
     */
    public function getFormatter(): NumberFormatter
    {
        return $this->frmtr;
    }

    /**
     * @function createDefaultFormatter
     * @return NumberFormatter
     */
    abstract protected function createDefaultFormatter(): NumberFormatter;
}
