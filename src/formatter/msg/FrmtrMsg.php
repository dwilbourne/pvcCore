<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\formatter\msg;

use pvc\formatter\Frmtr;
use pvc\formatter\FrmtrInterface;
use pvc\validator\base\data_type\ValidatorTypeMsg;

/**
 * Class FrmtrMsg
 */
abstract class FrmtrMsg extends Frmtr implements FrmtrInterface
{
    /**
     * FrmtrMsg constructor.
     */
    public function __construct()
    {
        $this->setTypeValidator(new ValidatorTypeMsg());
    }
}
