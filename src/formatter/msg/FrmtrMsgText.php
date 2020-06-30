<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\formatter\msg;

use pvc\formatter\FrmtrInterface;
use pvc\msg\Msg;
use pvc\sanitizer\SanitizerText;

class FrmtrMsgText extends FrmtrMsg implements FrmtrInterface
{
    /**
     * @function formatValue
     * @param Msg $msg
     * @return string
     */
    public function formatValue($msg): string
    {
        $sanitizer = new SanitizerText();
        $txt = vsprintf($msg->getMsgText(), $msg->getMsgVars());
        return $sanitizer->sanitize($txt);
    }
}
