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
 * Custom functions for seo encoded article.
 */
class ongr_sync_oxseoencoderarticle extends ongr_sync_oxseoencoderarticle_parent
{
    /**
     * @var array
     */
    protected $cacheCategories = array();

    /**
     * Check all article links.
     */
    public function checkAll()
    {
        $time = time();
        echo "Regenerating article links\n";

        $list = oxNew('oxarticlelist');
        $view = getViewName('oxarticles');
        $list->selectString("SELECT * FROM {$view} WHERE oxactive = 1");

        $index = 0;

        foreach ($list as $item) {
            $this->flushArticleLinks($item);
            echo '.';
            $index++;
            if ($index % 50 == 0 || $index == $list->count()) {
                echo round(100 * $index / $list->count()) . "%\n";
            }
        }

        echo 'Done in ' . (time() - $time) . " seconds \n";
    }

    /**
     * Flush article links.
     *
     * @param oxArticle $oArticle
     */
    public function flushArticleLinks($oArticle)
    {
        $this->getArticleUrl($oArticle, null, OXARTICLE_LINKTYPE_VENDOR);
        $this->getArticleUrl($oArticle, null, OXARTICLE_LINKTYPE_MANUFACTURER);

        $categories = $oArticle->getCategoryIds();

        foreach ($categories as $id) {
            $this->pingArticleCategoryUrl($oArticle, $id);
        }

        $oArticle->getLink();
    }

    /**
     * Return category by id.
     *
     * @param string $id
     *
     * @return oxCategory
     */
    protected function getCategoryById($id)
    {
        if ($this->cacheCategories[$id]) {
            return $this->cacheCategories[$id];
        }

        $this->cacheCategories[$id] = oxNew('oxCategory');
        $this->cacheCategories[$id]->load($id);

        return $this->cacheCategories[$id];
    }

    /**
     * Returns SEO uri for passed article.
     *
     * @param oxarticle $oArticle Article object.
     * @param string    $sActCatId
     */
    public function pingArticleCategoryUrl($oArticle, $sActCatId)
    {
        $oActCat = $this->getCategoryById($sActCatId);
        $iLang = $oArticle->getLanguage();

        if (!($sSeoUri = $this->_loadFromDb('oxarticle', $oArticle->getId(), $iLang, null, $sActCatId, true))) {
            if ($oActCat) {
                $blInCat = false;
                if ($oActCat->isPriceCategory()) {
                    $blInCat = $oArticle->inPriceCategory($sActCatId);
                } else {
                    $blInCat = $oArticle->inCategory($sActCatId);
                }
                if ($blInCat) {
                    $this->_createArticleCategoryUri($oArticle, $oActCat, $iLang);
                }
            }
        }
    }

    /**
     * Returns active vendor if available.
     *
     * @param oxarticle $oArticle Article.
     * @param int       $iLang    Language id.
     *
     * @return oxvendor | null
     */
    protected function _getVendor($oArticle, $iLang)
    {
        $oVendor = null;

        if ($sActVendorId = $oArticle->oxarticles__oxvendorid->value) {
            $oVendor = oxNew('oxVendor');
            if (!$oVendor->loadInLang($iLang, $sActVendorId)) {
                $oVendor = null;
            }
        }

        return $oVendor;
    }

    /**
     * Returns active manufacturer if available.
     *
     * @param oxarticle $oArticle Product.
     * @param int       $iLang    Language id.
     *
     * @return oxmanufacturer | null
     */
    protected function _getManufacturer($oArticle, $iLang)
    {
        $oManufacturer = null;
        if ($sActManufacturerId = $oArticle->oxarticles__oxmanufacturerid->value) {
            $oManufacturer = oxNew('oxManufacturer');
            if (!$oManufacturer->loadInLang($iLang, $sActManufacturerId)) {
                $oManufacturer = null;
            }
        }

        return $oManufacturer;
    }

    /**
     * Returns active list type.
     *
     * @return string
     */
    protected function _getListType()
    {
        $oView = $this->getConfig()->getActiveView();

        if ($oView && method_exists($oView, 'getListType')) {
            parent::_getListType();
        }

        return '';
    }
}
