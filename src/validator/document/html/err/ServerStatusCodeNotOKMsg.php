<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\document\html\err;

use pvc\msg\UserMsg;

/**
 * Class ServerResponseNotOKMsg
 */
class ServerStatusCodeNotOKMsg extends UserMsg
{
    /**
     * ServerStatusCodeNotOKMsg constructor.
     * @param int $statusCode
     */
    public function __construct(int $statusCode)
    {
        $msgVars = [$statusCode];
        $msgText = 'Server responded with HTTP status %s';
        parent::__construct($msgVars, $msgText);
    }
}
