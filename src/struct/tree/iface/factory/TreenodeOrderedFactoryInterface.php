<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\struct\tree\iface\factory;

use pvc\struct\tree\iface\node\TreenodeOrderedInterface;

/**
 * Interface TreenodeUnorderedFactoryInterface
 */
interface TreenodeOrderedFactoryInterface
{
    /**
     * @function makeTreenode
     * @param int $nodeid
     * @return TreenodeOrderedInterface
     */
    public function makeTreenode(int $nodeid) : TreenodeOrderedInterface;
}
