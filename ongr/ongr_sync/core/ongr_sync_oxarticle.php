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
 * Provides sync functions for article object.
 */
class ongr_sync_oxarticle extends ongr_sync_oxarticle_parent
{
    /**
     * Returns article seo url.
     *
     * @param int  $iLang  Language id.
     * @param bool $blMain Force to return main url [optional].
     *
     * @return string
     */
    public function getLink($iLang = null, $blMain = false)
    {
        return ONGRUrlHelper::url(parent::getLink($iLang, $blMain));
    }

    /**
     * Saves article with updated seo urls.
     *
     * @return mixed
     */
    public function save()
    {
        $ret = parent::save();

        oxRegistry::get('oxSeoEncoderArticle')->flushArticleLinks($this);

        return $ret;
    }

    /**
     * Returns ongr version id.
     *
     * @return int
     */
    public function getONGRVersionId()
    {
        $oDb = oxDb::getDb();
        $sql = 'SELECT ID FROM ongr_sync_jobs WHERE OXID=';
        $sql .= $oDb->quote($this->getId()) . ' ORDER BY ID DESC LIMIT 1';

        return ((int)$oDb->getOne($sql));
    }
}
