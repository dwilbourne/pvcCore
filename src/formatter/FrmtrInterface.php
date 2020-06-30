<?php declare(strict_types = 1);

namespace pvc\formatter;

/**
 * Interface FrmtrInterface
 * @package pvc\formatter
 */
interface FrmtrInterface
{

    /**
     * @function format
     * @param mixed $x
     * @return string
     */
    public function format($x): string;
}
