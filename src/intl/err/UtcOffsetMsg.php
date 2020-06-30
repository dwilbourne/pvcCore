<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\intl\err;

use pvc\msg\ErrorExceptionMsg;

/**
 * Class UtcOffsetMsg
 */
class UtcOffsetMsg extends ErrorExceptionMsg
{
    public function __construct(int $badOffset)
    {
        $msgVars = [$badOffset];
        $msgText = 'Invalid timezone offset.  Must be an integer between -12 and +14 (inclusive).';
        parent::__construct($msgVars, $msgText);
    }
}
