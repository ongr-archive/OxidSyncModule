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
 * Class ongr_sync_oxmanufacturer.
 */
class ongr_sync_oxmanufacturer extends ongr_sync_oxmanufacturer_parent
{
    /**
     * Returns the url of the manufacturer.
     *
     * @param int $iLang Language id.
     *
     * @return string
     */
    public function getLink($iLang = null)
    {
        return ONGRUrlHelper::url(parent::getLink($iLang));
    }

    /**
     * Manufacturer save function.
     *
     * @return mixed
     */
    public function save()
    {
        $ret = parent::save();

        $this->getLink();

        return $ret;
    }
}
