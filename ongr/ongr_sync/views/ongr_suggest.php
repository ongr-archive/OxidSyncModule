<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class ongr_suggest extends ongr_suggest_parent
{
    /**
     * @return mixed
     */
    public function render()
    {
        $result = parent::render();

        if (oxRegistry::getConfig()->getRequestParameter('ongr')) {
            $error = oxRegistry::getSession()->getVariable('Errors');
            $answer = array();
            if ($error && count($error['default']) > 0) {
                $answer['error'] = true;
                foreach ($error['default'] as $err) {
                    $answer[] = unserialize($err)->getOxMessage();
                }
                // Resetting errors from session.
                oxRegistry::getSession()->setVariable('Errors', array());
            } else {
                $answer[] = oxRegistry::getLang()->translateString('FORM_SUGGEST_SENDED');
            }
            oxRegistry::getUtils()->showMessageAndExit(json_encode($answer));
        }

        return $result;
    }
}
