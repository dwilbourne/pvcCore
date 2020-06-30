<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\document\html\err;

use pvc\err\throwable\Throwable;
use pvc\msg\UserMsg;

/**
 * Class ServerContentTypeException
 */
class ServerContentTypeMsg extends UserMsg
{
    /**
     * ServerContentTypeMsg constructor.
     */
    public function __construct()
    {
        $msgText = 'Server did not respond with the expected content-type (application/json)';
        parent::__construct([], $msgText);
    }
}
