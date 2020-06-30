<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\struct\lists;

use pvc\validator\base\ValidatorInterface;
use Iterator;
use ArrayAccess;
use Countable;

/**
 * Interface ListOrderedInterface
 */
interface ListOrderedInterface extends Iterator, ArrayAccess, Countable
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
     * crud operations
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

    /**
     * @function changeIndex
     * @param int $oldIndex
     * @param int $newIndex
     */
    public function changeIndex(int $oldIndex, int $newIndex): void;
}
