<?php

$GLOBALS['TL_HOOKS']['apiResponse'][] = array('GOODWILLRUN\GridBundle\Controller\ApiEnhancer', 'apiResponse');

$GLOBALS['TL_HOOKS']['apiContaoJson'][] = array('GOODWILLRUN\GridBundle\Controller\ApiEnhancer', 'apiContaoJson');

$GLOBALS['goodwillrun']['grid'] = array(
    'use_bootstrap' => true,
    'use_themes' => false,
    'use_parallax' => false,
    'use_background_skew' => false
);


if( TL_MODE == "FE" ) {
    $GLOBALS['TL_CSS'][] = 'bundles/goodwillrugridbundle/css/default.css|static';
    $GLOBALS['TL_JAVASCRIPT'][] = 'bundles/goodwillrugridbundle/js/default.js';
}
