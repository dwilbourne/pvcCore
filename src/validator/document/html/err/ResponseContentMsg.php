<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\document\html\err;

use pvc\msg\UserMsg;

/**
 * Class ServerContentException
 */
class ResponseContentMsg extends UserMsg
{
    /**
     * ResponseContentMsg constructor.
     * @param string $errmsg
     * @param string $contentType
     */
    public function __construct(string $errmsg, string $contentType)
    {
        $msgVars = [$contentType, $errmsg];
        $msgText = 'Unable to parse response body into %s. Errmsg was %s.';
        parent::__construct($msgVars, $msgText);
    }
}
