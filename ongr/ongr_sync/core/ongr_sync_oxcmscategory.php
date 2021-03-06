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
 * Provides functions to cms category.
 */
class ongr_sync_oxcmscategory extends ongr_sync_oxcmscategory_parent
{
    /**
     * Returns the url of the category.
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
     * Save cms category.
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
