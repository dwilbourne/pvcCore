<?php declare(strict_types = 1);

namespace pvc\struct\tree\iface\tree;

use pvc\struct\lists\ListOrderedInterface;
use pvc\struct\tree\iface\node\TreenodeOrderedInterface;

interface TreeOrderedInterface
{
    /**
     * @function getTreeId
     * @return int
     */
    public function getTreeId() : int;

    /**
     * @function setTreeId
     * @param int $id
     */
    public function setTreeId(int $id): void;

    /**
     * @function getRoot
     * @return TreenodeOrderedInterface|null
     */
    public function getRoot(): ?TreenodeOrderedInterface;

    /**
     * @function getNode
     * @param int $nodeid
     * @return TreenodeOrderedInterface|null
     */
    public function getNode(int $nodeid): ?TreenodeOrderedInterface;

    /**
     * @function hasNode
     * @param TreenodeOrderedInterface $node
     * @return bool
     */
    public function hasNode(TreenodeOrderedInterface $node) : bool;

    /**
     * @function getNodes
     * @return TreenodeOrderedInterface[]
     */
    public function getNodes(): array;

    /**
     * @function isEmpty
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * @function hydrateNodes
     * @param array $nodeCollection
     * @return void
     */
    public function hydrateNodes(array $nodeCollection) : void;

    /**
     * @function dehydrateNodes
     * @return array
     */
    public function dehydrateNodes(): array;

    /**
     * @function nodeCount
     * @return int
     */
    public function nodeCount(): int;

    /**
     * @function getParentOf
     * @param TreenodeOrderedInterface $node
     * @return TreenodeOrderedInterface|null
     */
    public function getParentOf(TreenodeOrderedInterface $node): ?TreenodeOrderedInterface;

    /**
     * @function getChildrenOf
     * @param TreenodeOrderedInterface $parent
     * @return array[TreenodeOrderedInterface]
     */
    public function getChildrenOf(TreenodeOrderedInterface $parent): array;

    /**
     * @function hasLeafWithId
     * @param int $nodeid
     * @return bool
     */
    public function hasLeafWithId(int $nodeid): bool;

    /**
     * @function hasInteriorNodeWithId
     * @param int $nodeid
     * @return bool
     */
    public function hasInteriorNodeWithId(int $nodeid): bool;

    /**
     * @function addNode
     * @param TreenodeOrderedInterface $node
     */
    public function addNode(TreenodeOrderedInterface $node): void;

    /**
     * @function deleteNode
     * @param TreenodeOrderedInterface $node
     * @param bool $deleteBranchOK
     */
    public function deleteNode(TreenodeOrderedInterface $node, bool $deleteBranchOK = false): void;

    /**
     * @function getTreeDepthFirst
     * @param TreenodeOrderedInterface|null $startNode
     * @param callable|null $callback
     * @return array[]TreenodeOrderedInterface
     */
    public function getTreeDepthFirst(TreenodeOrderedInterface $startNode = null, callable $callback = null): array;

    /**
     * @function getTreeBreadthFirst
     * @param TreenodeOrderedInterface|null $startNode
     * @param callable|null $callback
     * @param int|null $levels
     * @return array[]TreenodeOrderedInterface
     */
    public function getTreeBreadthFirst(
        TreenodeOrderedInterface $startNode = null,
        callable $callback = null,
        int $levels = null
    ): array;

    /**
     * @function getLeaves
     * @return array[]TreenodeOrderedInterface
     */
    public function getLeaves(): array;

    /**
     * @function getInteriorNodes
     * @return array[]TreenodeOrderedInterface
     */
    public function getInteriorNodes(): array;
}
