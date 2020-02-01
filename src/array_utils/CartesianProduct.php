<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\array_utils;

use ArrayIterator;
use Iterator;

/**
 * Class CartesianProduct
 *
 * This is a modification of code found more or less here:
 * https://github.com/hoaproject/Math/blob/master/Source/Combinatorics/Combination/CartesianProduct.php
 *
 * The constructor creates an array of iterators, which gives us access to the current position in each array.
 *
 */

class CartesianProduct  implements Iterator {

    /**
     * array of iterators used to create the cartesian product
     */
    protected $arrayOfIterators = [];
    
    /**
     * Key.  In order to conform to the Iterator interface, key has to be an integer.  But you can think of each
     * incremented key as mapping to an array which has the same length as the arrayOfIterators, and each
     * element of the array would be an integer that corresponds to the current position in the corresponding iterator.
     */
    protected $key = 0;

    /**
     * reference to the last iterator in the arrayOfIterators, which is used to determine whether the internal
     * pointers are valid
     */
    protected $lastIterator;
    
    /**
     * Constructor.  Each set must either be an array or must itself implement Iterator
     */
    public function __construct(array $sets) {
        for($i = 0; $i < count($sets); $i++) $this->addIterator($sets[$i]);
        if ($i > 0) $this->lastIterator = $this->arrayOfIterators[$i - 1];
    }

    protected function addIterator($set) {
        if (is_array($set)) $set = new ArrayIterator($set);
        elseif (!$set instanceof Iterator) throw new CartesianProductException();
        if (count($set) == 0) throw new CartesianProductException();
        $this->arrayOfIterators[] = $set;
    }

    /**
     * Get the current tuple.
     */
    public function current(): array {
        $currentTuple = [];
        foreach ($this->arrayOfIterators as $iterator) {
            $currentTuple[] = $iterator->current();
        }
        return $currentTuple;
    }

    /**
     * Get the current key.
     */
    public function key(): int {
        return $this->key;
    }

    /**
     * Advance the internal pointers.
     */
    public function next() : void {

        foreach($this->arrayOfIterators as $iterator) {
            $iterator->next();
            if (!$iterator->valid() && ($iterator != $this->lastIterator)) $iterator->rewind();
            // break the foreach loop - $iterator is valid or it is the last iterator
            // and the last iterator is invalid.
            else break;
        }
        $this->key++;
    }

    /**
     * Rewind the internal pointers.
     */
    public function rewind() {
        $this->key   = 0;
        foreach ($this->arrayOfIterators as $iterator) $iterator->rewind();
    }

    /**
     * The iterator is in a valid state if the lastIterator exists (meaning the arrayOfIterators is not empty)
     * and the last iterator is itself valid.
     */
    public function valid(): bool {
        return isset($this->lastIterator) && $this->lastIterator->valid();
    }

}