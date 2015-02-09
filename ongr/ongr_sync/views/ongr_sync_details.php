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
class ongr_sync_details extends ongr_sync_details_parent
{
    public function init()
    {
        parent::init();

        if (!oxRegistry::getConfig()->getRequestParameter('fnc')) {
            $oViewConf = $this->getViewConfig();
            oxRegistry::getUtils()->redirect($oViewConf->getHomeLink(), false);
        }
    }

    /**
     * Overwrite parent saveReview, dont make so much form data checkings, and return ajax response.
     */
    public function saveReview()
    {
        // Form response message.
        $response = array();

        if (($oUser = $this->getUser()) && ($oProduct = $this->getProduct())) {
            $dRating = oxRegistry::getConfig()->getRequestParameter('artrating');
            if ($dRating !== null) {
                $dRating = (int)$dRating;
            }

            if ($dRating !== null && $dRating >= 1 && $dRating <= 5) {
                $response['rated'] = 1;
                $response['message'] = oxRegistry::getLang()->translateString('PRODUCT_RATING_RATED_THANK_YOU');

                $oRating = oxNew('oxrating');
                if ($oRating->allowRating($oUser->getId(), 'oxarticle', $oProduct->getId())) {
                    $oRating->oxratings__oxuserid = new oxField($oUser->getId());
                    $oRating->oxratings__oxtype = new oxField('oxarticle');
                    $oRating->oxratings__oxobjectid = new oxField($oProduct->getId());
                    $oRating->oxratings__oxrating = new oxField($dRating);
                    $oRating->save();
                    $oProduct->addToRatingAverage($dRating);
                }
            }

            if (($sReviewText = trim((string)oxRegistry::getConfig()->getSystemConfigParameter('rvw_txt', true)))) {
                $response['commented'] = 1;
                $response['message'] = oxRegistry::getLang()->translateString('PRODUCT_RATING_COMMENT_THANK_YOU');

                $oReview = oxNew('oxreview');
                $oReview->oxreviews__oxobjectid = new oxField($oProduct->getId());
                $oReview->oxreviews__oxtype = new oxField('oxarticle');
                $oReview->oxreviews__oxtext = new oxField($sReviewText, oxField::T_RAW);
                $oReview->oxreviews__oxlang = new oxField(oxRegistry::getLang()->getBaseLanguage());
                $oReview->oxreviews__oxuserid = new oxField($oUser->getId());
                $oReview->oxreviews__oxrating = new oxField(($dRating !== null) ? $dRating : 0);
                $oReview->save();
            }

            if (!isset($response['message'])) {
                $response['error'] = oxRegistry::getLang()->translateString('PRODUCT_RATING_ERROR_CONTENT');
            }
        } else {
            $response['error'] = oxRegistry::getLang()->translateString('PRODUCT_RATING_ERROR');
        }

        oxRegistry::get('oxUtils')->showMessageAndExit(json_encode($response));
    }

    public function appliances()
    {
        $this->render();
    }
}
