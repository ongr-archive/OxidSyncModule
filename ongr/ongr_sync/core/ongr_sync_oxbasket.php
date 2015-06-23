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
 * Sync basket data.
 */
class ongr_sync_oxbasket extends ongr_sync_oxbasket_parent
{
    /**
     * Basket data
     */
    const BASKET_DATA_COOKIE_NAME = 'ongr_basket';

    /**
     * Hook after basket update.
     */
    public function afterUpdate()
    {
        parent::afterUpdate();

        $this->syncData();
    }

    /**
     * @return array
     */
    protected function getSyncData()
    {
        $currency = $this->getBasketCurrency();
        $sign = $currency->sign;
        json_encode($sign);
        if (json_last_error()) {
            $sign = '';
        }

        if (count($this->getContents()) > 0) {
            return array(
                'amount' => $this->getFPrice() . ' ' . $sign
            );
        }

        return array();
    }

    /**
     * Delete basket data.
     */
    public function deleteBasket()
    {
        $this->syncData(array());
        parent::deleteBasket();
    }

    /**
     * Sync basket data.
     *
     * @param array $data
     *
     * @return bool
     */
    protected function syncData($data = null)
    {
        return setcookie(
            self::BASKET_DATA_COOKIE_NAME,
            json_encode($data ? $data : $this->getSyncData()),
            class_exists('ongr_oxcmp_user') ? (time() + ongr_sync_oxuser::BASKET_LIFETIME) : 0,
            '/',
            '',
            false,
            false
        );
    }
}
