<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\intl\err;

use pvc\msg\ErrorExceptionMsg;

/**
 * Class InvalidLocaleMsg
 */
class InvalidLocaleMsg extends ErrorExceptionMsg
{
    public function __construct(string $badLocale)
    {
        $msgVars = [$badLocale];
        $msgText = 'Invalid locale specified (%s).';
        parent::__construct($msgVars, $msgText);
    }
}
