<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\base\required;

use pvc\msg\UserMsg;

/**
 * Class ValidatorNotNullMsg
 */
class ValidatorNotNullMsg extends UserMsg
{
    /**
     * ValidatorNotNullMsg constructor.
     */
    public function __construct()
    {
        $msgVars = [];
        $msgText = 'value cannot be null';
        parent::__construct($msgVars, $msgText);
    }
}
