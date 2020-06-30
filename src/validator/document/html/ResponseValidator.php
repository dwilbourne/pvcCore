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

namespace pvc\validator\document\html;

use pvc\msg\Msg;
use pvc\msg\UserMsg;
use pvc\msg\UserMsgInterface;
use pvc\validator\base\ValidatorInterface;
use Psr\Http\Message\ResponseInterface as HttpResponse;
use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentMsg;
use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentException;
use pvc\validator\document\html\err\ResponseContentMsg;
use pvc\validator\document\html\err\ServerContentTypeMsg;
use pvc\validator\document\html\err\ServerStatusCodeNotOKMsg;
use pvc\msg\MsgInterface;

/**
 * Class ResponseValidator
 */
class ResponseValidator implements ValidatorInterface
{

    /**
     * @var UserMsg
     */
    protected UserMsg $errmsg;

    /**
     * @function validate
     * @param HttpResponse $response
     * @return bool
     * @throws InvalidArgumentException
     */
    public function validate($response): bool
    {
        if (!$response instanceof HttpResponse) {
            $msg = new InvalidArgumentMsg('HttpResponse');
            throw new InvalidArgumentException($msg);
        }

        if ($response->getStatusCode() !== 200) {
            $this->errmsg = new ServerStatusCodeNotOKMsg($response->getStatusCode());
            return false;
        }

        if (strpos($response->getHeader('Content-Type')[0], 'application/json') === false) {
            $this->errmsg = new ServerContentTypeMsg();
            return false;
        }

        $body = (string) $response->getBody();
        json_decode($body, true);
        if (json_last_error()) {
            $this->errmsg = new ResponseContentMsg('json', json_last_error_msg());
            return false;
        }
        return true;
    }


    /**
     * This method is required by the interface but there is no code that ever actually sets an error message.
     * @function getErrMsg
     * @return UserMsgInterface|null
     */
    public function getErrMsg(): ?UserMsgInterface
    {
        return $this->errmsg ?? null;
    }
}
