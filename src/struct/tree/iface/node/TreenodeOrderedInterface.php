<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\struct\tree\iface\node;

use pvc\struct\lists\ListOrderedInterface;
use pvc\struct\tree\iface\tree\TreeOrderedInterface;

/**
 * Interface TreenodeOrderedInterface
 * @package pvc\struct\tree\iface\node
 */
interface TreenodeOrderedInterface extends TreenodeInterface
{
    /**
     * @function setReferences
     * @param TreeOrderedInterface $tree
     */
    public function setReferences(TreeOrderedInterface $tree): void;

    /**
     * @function hasReferencesSet
     * @return bool
     */
    public function hasReferencesSet(): bool;

    /**
     * @function getTree
     * @return TreeOrderedInterface|null
     */
    public function getTree(): ?TreeOrderedInterface;

    /**
     * @function getParent
     * @return TreenodeOrderedInterface|null
     */
    public function getParent(): ?TreenodeOrderedInterface;

    /**
     * @function getChild
     * @param int $nodeid
     * @return TreenodeOrderedInterface|null
     */
    public function getChild(int $nodeid): ?TreenodeOrderedInterface;

    /**
     * @function getChildren
     * @return ListOrderedInterface
     */
    public function getChildren(): ListOrderedInterface;

    /**
     * @function getChildrenArray
     * @return array
     */
    public function getChildrenArray() : array;

    /**
     * @function getSiblings
     * @return ListOrderedInterface|null
     */
    public function getSiblings(): ?ListOrderedInterface;

    /**
     * @function isLeaf
     * @return bool
     */
    public function isLeaf(): bool;

    /**
     * @function isInteriorNode
     * @return bool
     */
    public function isInteriorNode(): bool;

    /**
     * @function isRoot
     * @return bool
     */
    public function isRoot(): bool;

    /**
     * @function isDescendantOf
     * @param TreenodeOrderedInterface $node
     * @return bool
     */
    public function isDescendantOf(TreenodeOrderedInterface $node): bool;

    /**
     * @function isAncestorOf
     * @param TreenodeOrderedInterface $node
     * @return bool
     */
    public function isAncestorOf(TreenodeOrderedInterface $node): bool;

    /**
     * @function setIndex
     * @param int $index
     */
    public function setIndex(int $index): void;

    /**
     * @function getIndex
     * @return int
     */
    public function getIndex(): int;

    /**
     * @function setHydrationIndex
     * @param int $index
     */
    public function setHydrationIndex(int $index): void;

    /**
     * @function getHydrationIndex
     * @return int|null
     */
    public function getHydrationIndex(): ?int;
}
