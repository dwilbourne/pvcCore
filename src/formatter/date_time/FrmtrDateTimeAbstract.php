<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\formatter\date_time;

use pvc\formatter\Frmtr;
use pvc\formatter\FrmtrInterface;
use pvc\intl\Locale;

/**
 * Class FrmtrDateTimeAbstract
 */
abstract class FrmtrDateTimeAbstract extends Frmtr implements FrmtrInterface
{

    /**
     * @var Locale
     */
    protected Locale $locale;


    /**
     * FrmtrDateTimeAbstract constructor.
     * @param Locale|null $locale
     */
    public function __construct(Locale $locale = null)
    {
        $this->setLocale($locale);
    }

    /**
     * @function getLocale
     * @return Locale
     */
    public function getLocale(): Locale
    {
        return $this->locale;
    }

    /**
     * @function setLocale
     * @param Locale|null $locale
     */
    public function setLocale(Locale $locale = null): void
    {
        if (is_null($locale)) {
            $locale = new locale();
        }
        $this->locale = $locale;
    }

    /**
     * @function getPatternFromLocale
     * @return string
     */
    abstract public function getPatternFromLocale(): string;
}
