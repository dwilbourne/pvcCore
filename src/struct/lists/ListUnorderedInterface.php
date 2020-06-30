<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\struct\lists;

use ArrayAccess;
use Countable;
use Iterator;
use pvc\validator\base\ValidatorInterface;

/**
 * Interface ListUnorderedInterface
 * @package pvc\struct\lists
 *
 * This interface is shared by both ordered lists and unordered lists.  Ordered lists must use
 * non-negative integers as keys (kept in sequence order) whereas unordered lists can, like
 * php arrays, use either strings or integers.  Because the interface is shared, the arguments
 * to the methods cannot by specifically typed in the call signature of the method.
 *
 */
interface ListUnorderedInterface extends Iterator, ArrayAccess, Countable
{
    /**
     * @function isEmpty
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * @function getElement
     * @param int $key
     * @return mixed
     */
    public function getElement(int $key);

    /**
     * @function getElements
     * @return mixed[]
     */
    public function getElements(): array;

    /**
     * @function getKeys
     * @return int[]
     */
    public function getKeys(): array;

    /**
     * crud operations.  In order to keep the semantics the same, the return values for these methods
     *mirror those for offsetSet and offsetUnset
     */

    /**
     * @function add
     * @param int $key
     * @param mixed $value
     */
    public function add(int $key, $value): void;

    /**
     * @function update
     * @param int $key
     * @param mixed $value
     */
    public function update(int $key, $value): void;

    /**
     * @function delete
     * @param int $key
     */
    public function delete(int $key): void;

    /**
     * @function push
     * @param mixed $value
     */
    public function push($value): void;
}
