<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator\document\html;

use pvc\msg\MsgCollection;
use pvc\msg\MsgInterface;

/**
 * Class Messages
 *
 * collection of message objects.  A message (object) is one of the pieces of the response that comes
 * back from the http client that the validator uses.
 *
 */
class Messages extends MsgCollection implements MsgInterface
{

}
