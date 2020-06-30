<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\struct\tree\iface\factory;

use pvc\struct\tree\iface\node\TreenodeInterface;

/**
 * Interface TreenodeFactoryInterface
 */
interface TreenodeFactoryInterface
{
    /**
     * @function makeTreenode
     * @param int $nodeid
     * @return TreenodeInterface
     */
    public function makeTreenode(int $nodeid) : TreenodeInterface;
}
