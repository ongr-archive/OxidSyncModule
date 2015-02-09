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
 * Custom functions for seo encoder content.
 */
class ongr_sync_oxseoencodercontent extends ongr_sync_oxseoencodercontent_parent
{
    /**
     * Check all content links.
     */
    public function checkAll()
    {
        $time = time();
        echo "Regenerating contents links\n";

        $list = oxNew('oxcontentlist');
        $view = getViewName('oxcontents');

        $list->selectString("SELECT * FROM {$view}");

        $index = 0;

        foreach ($list as $item) {
            $item->getLink();
            echo '.';
            $index++;
            if ($index % 50 == 0 || $index == $list->count()) {
                echo round(100 * $index / $list->count()) . "%\n";
            }
        }

        echo 'Done in ' . (time() - $time) . " seconds \n";
    }
}
