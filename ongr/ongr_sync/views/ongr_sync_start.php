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
class ongr_sync_start extends ongr_sync_start_parent
{

    public function init()
    {
        parent::init();

//        if (!oxRegistry::getConfig()->getRequestParameter('fnc')) {
//            $oViewConf = $this->getViewConfig();
//            oxRegistry::getUtils()->redirect($oViewConf->getHomeLink(), false);
//        }
    }

    public function sendPromotion()
    {
        $promoContent = oxNew('oxcmscontent');
        $promoContent->loadByIdent('footer_promotion');

        $userEmail = oxRegistry::getConfig()->getSystemConfigParameter('promotion-email');
        $email = oxNew('oxemail');

        $message = "Promotion: {$promoContent->oxcms_contents__oxtitle->value}<br>
        Message: " . strip_tags($promoContent->oxcms_contents__oxcontent->value) . "<br>
        Email: {$userEmail}";
        if ($email->sendContactMail($userEmail, $promoContent->oxcms_contents__oxtitle->value, $message)) {
            oxRegistry::getUtils()->showMessageAndExit(json_encode(array('success' => 1)));
        }

        oxRegistry::getUtils()->showMessageAndExit(json_encode(array('error' => 1)));
    }
}
