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
 * Sync login status.
 */
class ongr_sync_oxuser extends ongr_sync_oxuser_parent
{
    /**
     * User data.
     */
    const USER_DATA_COOKIE_NAME = 'ongr_user';
    /**
     * Basket lifetime.
     */
    const BASKET_LIFETIME = 3600;

    /**
     * @return array
     */
    public function getONGRSyncData()
    {
        $userName = $this->oxuser__oxusername->value;

        return array(
            'userName' => $userName,
            'sid' => oxRegistry::getSession()->getId()
        );
    }

    /**
     * Remove ongr data.
     *
     * @return bool
     */
    public static function deleteONGRData()
    {
        return setcookie(
            self::USER_DATA_COOKIE_NAME,
            '',
            time() - 3600,
            '/',
            '',
            false,
            false
        );
    }

    /**
     * Checks if cookie exists.
     *
     * @return bool
     */
    public static function ongrDataExists()
    {
        return oxRegistry::get('oxUtilsServer')->getOxCookie(self::USER_DATA_COOKIE_NAME) ? true : false;
    }

    /**
     * Sync user data.
     *
     * @param array $data
     *
     * @return bool
     */
    public function syncONGRData($data = null)
    {
        return setcookie(
            self::USER_DATA_COOKIE_NAME,
            json_encode($data ? $data : $this->getONGRSyncData()),
            0,
            '/',
            '',
            false,
            false
        );
    }
}
