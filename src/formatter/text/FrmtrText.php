<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\formatter\text;

use pvc\formatter\Frmtr;
use pvc\validator\base\data_type\ValidatorTypeText;

/**
 * Class FrmtrText
 */
class FrmtrText extends Frmtr
{

    /**
     * FrmtrText constructor.
     */
    public function __construct()
    {
        $vt = new ValidatorTypeText();
        $this->setTypeValidator($vt);
    }

    /**
     * @function formatValue
     * @param string $value
     * @return string
     */
    protected function formatValue($value): string
    {
        return '' . $value;
    }
}
