<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\intl\err;

use pvc\msg\ErrorExceptionMsg;
use pvc\msg\Msg;

/**
 * Class InvalidTimezoneMsg
 */
class InvalidTimezoneMsg extends ErrorExceptionMsg
{
    public function __construct(string $tz)
    {
        $msgVars = [$tz];
        $msgText = 'Invalid timezone: %s';
        parent::__construct($msgVars, $msgText);
    }
}
