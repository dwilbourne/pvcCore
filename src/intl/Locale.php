<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\intl;

use pvc\intl\err\InvalidLocaleException;
use pvc\intl\err\InvalidLocaleMsg;
use Symfony\Component\Intl\Locales;
use Locale as phpLocale;

/**
 * Class insures that the locale specified is valid.
 *
 * The format uses underscores, not hyphens (e.g. fr_FR, not fr-FR).
 *
 * This class also allows you to extract the language from the set locale.
 *
 * Class Locale.
 */
class Locale
{
    /**
     * @var string
     */
    protected string $locale;

    /**
     * Locale constructor.
     * @param string|null $locale
     * @throws InvalidLocaleException
     */
    public function __construct(string $locale = null)
    {
        $this->setLocale($locale ? $locale : phpLocale::getDefault());
    }

    /**
     * @function setLocale
     * @param string $locale
     * @throws InvalidLocaleException
     */
    public function setLocale(string $locale) : void
    {
        if (!Locales::exists($locale)) {
            $msg = new InvalidLocaleMsg($locale);
            throw new InvalidLocaleException($msg);
        }
        $this->locale = $locale;
    }

    /**
     * @function getLocale
     * @return string
     */
    public function getLocale() : string
    {
        return $this->locale;
    }

    /**
     * @function getLanguage
     * @return string
     */
    public function getLanguage() : string
    {
        return phpLocale::getPrimaryLanguage($this->locale);
    }

    public function __toString() : string
    {
        return $this->getLocale();
    }
}
