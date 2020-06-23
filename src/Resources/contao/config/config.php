<?php

$GLOBALS['TL_HOOKS']['apiResponse'][] = array('GOODWILLRUN\Grid\Controller\ApiEnhancer', 'apiResponse');

$GLOBALS['TL_HOOKS']['apiContaoJson'][] = array('GOODWILLRUN\Grid\Controller\ApiEnhancer', 'apiContaoJson');

$GLOBALS['goodwillrun']['grid'] = array(
    'use_bootstrap' => true,
    'use_themes' => false,
    'use_parallax' => false,
    'use_background_skew' => false
);
