<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class ongr_account extends ongr_account_parent
{

    /**
     * Redirect after login.
     *
     * @return mixed
     */
    public function redirectAfterLogin()
    {
        $user = $this->getUser();

        if (($sSource = oxRegistry::getConfig()->getRequestParameter('destination')) && $user
            && $user->oxuser__oxpassword->value
        ) {
            $anchor = oxRegistry::getConfig()->getRequestParameter('anchor');
            if ($anchor) {
                $anchor = '#' . $anchor;
            }

            return oxRegistry::get('oxUtils')->redirect(
                $sSource = urldecode(oxRegistry::getConfig()->getRequestParameter('destination')) . $anchor,
                false,
                302
            );
        }

        return parent::redirectAfterLogin();
    }

    /**
     * @return mixed
     */
    public function getNavigationParams()
    {
        $aParams = parent::getNavigationParams();

        if ($sSource = oxRegistry::getConfig()->getRequestParameter('destination')) {
            $aParams['destination'] = $sSource;
        }

        if ($sSource = oxRegistry::getConfig()->getRequestParameter('anchor')) {
            $aParams['anchor'] = $sSource;
        }

        return $aParams;
    }
}
