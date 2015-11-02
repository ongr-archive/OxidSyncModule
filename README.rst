OXID sync module
================

This replaces OXID frontend with ongr site. Most request will be redirected to a new site, only adding product to cart will be done in OXID. And ONGR site will know about cart from ``ongr_basket`` cookie and user data will be available in
``ongr_user`` cookie.

Installation
~~~~~~~~~~~~

Place ``ongr`` catalog in OXID shop modules directory then via admin panel set ONGR url in module settings and enable it .


Usage
~~~~~

Prepare SEO urls for export/sync to ongr platform.
Iterate trough articles, categories and content to generate all possible SEO url links:

articles:

.. code-block:: php

    $list = oxNew('oxlist');
    $list->init('oxarticle');
    $list->selectString('select * from oxarticles');

    foreach ($list as $article) {
        $article->getLink();
    }

categories:
    
.. code-block:: php
    
    $list = oxNew('oxlist');
    $list->init('oxcategory');
    $list->selectString('select * from oxcategories');
    
    foreach ($list as $category) {
        $category->getLink();
    }
    
and content:

.. code-block:: php

    $list = oxNew('oxlist');
    $list->init('oxcontent');
    $list->selectString('select * from oxcontents');
    
    foreach ($list as $content) {
        $content->getLink();
    }
    
Don't forget to iterate through all subshops and languages.
