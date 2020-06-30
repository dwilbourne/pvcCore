<?php declare(strict_types = 1);
/**
 * This file is part of the pvc\htmlValidator package, whic is an adaptation of the
 * rexxars\html-validator package authored by Espen Hovlandsdal <espen@hovlandsdal.com>.
 *
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version 1.0
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace pvc\validator\document\html\err;

use pvc\err\throwable\exception\stock_rebrands\Exception;
use pvc\msg\ErrorExceptionMsg;
use pvc\msg\Msg;
use pvc\err\throwable\ErrorExceptionConstants as ec;
use Throwable;

/**
 * Class ServerException
 */
class ServerException extends Exception
{

    /**
     * ServerException constructor.
     * @param Throwable|null $previous
     */
    public function __construct(Throwable $previous = null)
    {
        $msgText = 'Validation server exception occurred.';
        $msg = new ErrorExceptionMsg([], $msgText);
        $code = ec::HTML_VALIDATOR_SERVER_EXCEPTION;
        parent::__construct($msg, $code, $previous);
    }
}
