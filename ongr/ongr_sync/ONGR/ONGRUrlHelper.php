<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Provide helper functions for url formating.
 */
class ONGRUrlHelper extends oxSuperCfg
{
    /**
     * @var ONGRUrlHelper
     */
    protected static $instance = null;

    /**
     * @var string
     */
    protected $oxidRootUrl;

    /**
     * @var string Shop root url.
     */
    protected $rootUrl;

    /**
     * @return ONGRUrlHelper
     */
    public static function getInstance()
    {
        if (self::$instance !== null) {
            return self::$instance;
        }

        self::$instance = oxNew('ONGRUrlHelper');

        return self::$instance;
    }

    /**
     * Provides url to ONGR.
     *
     * @param string $link
     *
     * @return string
     */
    public static function url($link)
    {
        return self::getInstance()->ongrPrepareLink($link);
    }

    /**
     * Returns oxid root url.
     *
     * @return string
     */
    protected function getOxidRootUrl()
    {
        if ($this->oxidRootUrl !== null) {
            return $this->oxidRootUrl;
        }

        $this->oxidRootUrl = $this->getConfig()->getConfigParam('sShopURL');

        return $this->oxidRootUrl;
    }

    /**
     * Returns oxid root url.
     *
     * @return string
     */
    protected function getShopRootUrl()
    {
        if ($this->rootUrl !== null) {
            return $this->rootUrl;
        }

        $this->rootUrl = $this->getConfig()->getConfigParam('sRootUrl');

        return $this->rootUrl;
    }

    /**
     * Prepare link to ONGR.
     *
     * @param string $link
     *
     * @return string
     */
    public function ongrPrepareLink($link)
    {
        return str_replace($this->getOxidRootUrl(), $this->getShopRootUrl(), $link);
    }
}
