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
 * Provides functions for oxid/ongr sync.
 */
class ongr_sync_oxviewconfig extends ongr_sync_oxviewconfig_parent
{

    /**
     * Returns shops home link.
     *
     * @return string
     */
    public function getHomeLink()
    {
        return ONGRUrlHelper::url(parent::getHomeLink());
    }

    /**
     * Return search listener url.
     *
     * @return string
     */
    public function getONGRSearchLink()
    {
        return $this->getConfig()->getConfigParam('sRootUrl') . 'search';
    }

    /**
     * @return string
     */
    public function getLoginLink()
    {
        $params = array(
            'cl' => 'account'
        );

        if (oxRegistry::getConfig()->getRequestParameter('destination')) {
            $params['destination'] = urldecode(oxConfig::getParameter('destination'));
        }

        if (oxRegistry::getConfig()->getRequestParameter('anchor')) {
            $params['anchor'] = urldecode(oxRegistry::getConfig()->getRequestParameter('anchor'));
        }

        return $this->getSelfLink() . http_build_query($params);
    }

    protected $_partCatTree = array();

    /**
     * Return partial sub tree.
     *
     * @param $id
     *
     * @return mixed
     */
    public function getPartialCatTree($id)
    {
        if (isset($this->_partCatTree[$id])) {
            return $this->_partCatTree[$id];
        }

        $categoryList = oxRegistry::get('oxCategoryList');
        $categoryList->buildActCatList($id);

        $this->_partCatTree[$id] = $categoryList;

        return $categoryList;
    }

    /**
     * Return special category id witch children need show on category menu left side.
     *
     * @return string
     */
    public function getSpecCategoryId()
    {
        return $this->getConfig()->getConfigParam('sSpecCategoryId');
    }
}