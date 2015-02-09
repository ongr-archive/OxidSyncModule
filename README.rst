Oxid sync module
================

Installation
~~~~~~~~~~~~

Place ``ongr`` catalog in OXID shop modules directory and enable it via admin panel.


Usage
~~~~~

Prepare SEO urls for export/sync to ongr platform.
This will iterate trough all articles and generate all possible SEO url links for article.

.. code-block:: php

    $list = oxNew('oxlist');
    $list->init('oxarticle');
    $list->selectString('select * from oxarticles');

    foreach ($list as $article) {
        $article->save();
    }
