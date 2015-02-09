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
 * Class ongr_sync_oxcmp_user.
 */
class ongr_sync_oxcmp_user extends ongr_sync_oxcmp_user_parent
{
    /**
     * @param oxUser $oUser
     */
    protected function _afterLogin($oUser)
    {
        $ret = parent::_afterLogin($oUser);

        $oUser->syncONGRData();

        return $ret;
    }

    /**
     * Logout hook.
     */
    protected function _afterLogout()
    {
        $ret = parent::_afterLogout();

        oxNew('oxUser')->syncONGRData(array());

        return $ret;
    }

    protected function _loadSessionUser()
    {
        parent::_loadSessionUser();

        $user = $this->getUser();

        $dataExists = ongr_sync_oxuser::ongrDataExists();
        $userAuthenticated = ($user && $user->oxuser__oxpassword->value) ? true : false;
        if (!$userAuthenticated && $dataExists) {
            ongr_sync_oxuser::deleteONGRData();
        } elseif (!$dataExists && $userAuthenticated) {
            $user->syncONGRData();
        }
    }
}
