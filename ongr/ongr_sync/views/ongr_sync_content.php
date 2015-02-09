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
 * Disables controller.
 */
class ongr_sync_content extends ongr_sync_content_parent
{
    public function init()
    {
        parent::init();
        /*
                if (!oxConfig::getParameter('fnc')) {
                    $oViewConf = $this->getViewConfig();
                    oxUtils::getInstance()->redirect($oViewConf->getHomeLink(), false);
                }*/
    }
}
