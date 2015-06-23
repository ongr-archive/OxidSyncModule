Oxid sync module
================

This replaces oxid frontend with ongr site. Most request will be redirected to a new site, only adding product to cart
will be done in oxid. And ONGR site will know about cart from ``ongr_basket`` cookie and user data will be available in
``ongr_user`` cookie.

Installation
~~~~~~~~~~~~

Place ``ongr`` catalog in OXID shop modules directory then via admin panel set ONGR url in module settings and enable it .


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
