<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class ongr_sync_oxcategorylist extends ongr_sync_oxcategorylist_parent
{
    /**
     * Set active category from witch will be load tree.
     *
     * @param string $id
     */
    public function setActCat($id)
    {
        $this->_sActCat = $id;
    }

    /**
     * Fetches raw categories and does postprocessing for adding depth information.
     *
     * @param string $id
     */
    public function buildActCatList($id)
    {
        $this->setActCat($id);

        startProfile('buildCategoryList');

        $this->_blForceFull = false;
        $this->_blHideEmpty = false;
        $sql = $this->_getSelectString(false);
        $this->selectString($sql);

        stopProfile('buildCategoryList');
    }
}
