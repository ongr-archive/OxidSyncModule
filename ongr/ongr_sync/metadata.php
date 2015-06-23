<?php

/**
 * Metadata version
 */
$sMetadataVersion = '1.0';

/**
 * Module information
 */
$aModule = array(
    'id' => 'ongr_sync',
    'title' => 'ONGR OXID synchronization',
    'description' => 'All features needed for oxid_ongr data sync.',
    'thumbnail' => '',
    'version' => '1.0.0',
    'author' => 'Ongr.io team',
    'url' => 'http://www.nfq.com',
    'extend' => array(
        'oxbasket' => 'ongr/ongr_sync/core/ongr_sync_oxbasket',
        'suggest' => 'ongr/ongr_sync/views/ongr_suggest',
        'account' => 'ongr/ongr_sync/views/ongr_account',
        'oxviewconfig' => 'ongr/ongr_sync/views/ongr_sync_oxviewconfig',
        'oxcmp_user' => 'ongr/ongr_sync/views/ongr_sync_oxcmp_user',
        'start' => 'ongr/ongr_sync/views/ongr_sync_start',
        'alist' => 'ongr/ongr_sync/views/ongr_sync_alist',
        'details' => 'ongr/ongr_sync/views/ongr_sync_details',
        'content' => 'ongr/ongr_sync/views/ongr_sync_content',
        'oxcms_view' => 'ongr/ongr_sync/views/ongr_sync_oxcms_view',
        'oxcms_tree' => 'ongr/ongr_sync/views/ongr_sync_oxcms_tree',
        'oxarticle' => 'ongr/ongr_sync/core/ongr_sync_oxarticle',
        'oxcmscontent' => 'ongr/ongr_sync/core/ongr_sync_oxcmscontent',
        'oxcontent' => 'ongr/ongr_sync/core/ongr_sync_oxcontent',
        'oxcmscategory' => 'ongr/ongr_sync/core/ongr_sync_oxcmscategory',
        'oxcategory' => 'ongr/ongr_sync/core/ongr_sync_oxcategory',
        'oxuser' => 'ongr/ongr_sync/core/ongr_sync_oxuser',
        'oxutilsfile' => 'ongr/ongr_sync/core/ongr_sync_oxutilsfile',
        'oxseoencoderarticle' => 'ongr/ongr_sync/core/ongr_sync_oxseoencoderarticle',
        'oxseoencodercmscontent' => 'ongr/ongr_sync/core/ongr_sync_oxseoencodercmscontent',
        'oxseoencodercmscategory' => 'ongr/ongr_sync/core/ongr_sync_oxseoencodercmscategory',
        'oxseoencodercategory' => 'ongr/ongr_sync/core/ongr_sync_oxseoencodercategory',
        'oxseoencodercontent' => 'ongr/ongr_sync/core/ongr_sync_oxseoencodercontent',
        'oxmanufacturer' => 'ongr/ongr_sync/core/ongr_sync_oxmanufacturer',
        'oxcategorylist' => 'ongr/ongr_sync/core/ongr_sync_oxcategorylist',
    ),
    'files' => array(
        'ONGRUrlHelper' => 'ongr/ongr_sync/ONGR/ONGRUrlHelper.php',
    ),
    'templates' => array(),
    'settings'      => [
        [
            'group' => 'ONGR',
            'name' => 'sRootUrl',
            'type' => 'str',
            'value' => 'http://test.dev/',
        ],
    ],
    'blocks' => array()
);
