<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\validator;


/**
 * Class mytest
 */
class mytest {

    /**
     * @function foo
     * @param string $s
     * @return int
     */
    protected function foo(string $s): int {
        return strlen($s);
    }

    /**
     * @function bar
     * @param int $n
     * @return string
     */
    protected function bar(int $n): string {
        return $n >= 0 ? "yes" : "no";
    }

}