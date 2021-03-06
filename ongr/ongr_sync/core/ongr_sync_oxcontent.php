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
 * Provides sync functions.
 */
class ongr_sync_oxcontent extends ongr_sync_oxcontent_parent
{
    /**
     * Content save function.
     *
     * @return mixed
     */
    public function save()
    {
        $ret = parent::save();

        $this->getLink();

        return $ret;
    }
}
