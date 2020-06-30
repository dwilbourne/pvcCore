<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\base\data_type\err;

use pvc\msg\UserMsg;

/**
 * Class ValidatorTypeMsg
 */
class ValidatorTypeMsg extends UserMsg
{
    public function __construct(string $dataType)
    {
        $msgVars = [$dataType];
        $msgText = 'value nust be of type %s';
        parent::__construct($msgVars, $msgText);
    }
}
