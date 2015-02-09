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
 * Disables controller
 */
class ongr_sync_oxcms_view extends ongr_sync_oxcms_view_parent
{

    public function init()
    {
        parent::init();

        if (!oxRegistry::getConfig()->getRequestParameter('fnc')) {
            $oViewConf = $this->getViewConfig();
            oxRegistry::getUtils()->redirect($oViewConf->getHomeLink(), false);
        }
    }
}
