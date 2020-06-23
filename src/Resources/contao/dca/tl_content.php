<?php
$USE_BOOTSTRAP = $GLOBALS['goodwillrun']['grid']['use_bootstrap'];
$USE_COLORTHEME = $GLOBALS['goodwillrun']['grid']['use_themes'];
$USE_PARALLAX = $GLOBALS['goodwillrun']['grid']['use_parallax'];
$USE_BACKGROUND_SKEW = $GLOBALS['goodwillrun']['grid']['use_background_skew'];

$verticalAlignment = array(
    '' => 'Default',
    'flex-start' => 'Oben',
    'center' => 'Mitte',
    'flex-end' => 'Unten',
);
$horizontalAlignment = array(
    '' => 'Default',
    'flex-start' => 'Links',
    'center' => 'Mitte',
    'flex-end' => 'Rechts',
);
$sizes = array(
    '100%' => '1/1',
    '75%' => '3/4',
    '50%' => '1/2',
    '33.333%' => '1/3',
    '66.666%' => '2/3',
    '25%' => '1/4'
);
$sizes_desktop = array(
    '' => 'Default',
    '100%' => '1/1',
    '75%' => '3/4',
    '50%' => '1/2',
    '33.333%' => '1/3',
    '66.666%' => '2/3',
    '25%' => '1/4'
);
if ($USE_BOOTSTRAP) {
    $sizes = array(
        'col-12' => '1/1 (100%)',
        'col-10' => '5/6 (83%)',
        'col-9' => '3/4 (75%)',
        'col-8' => '2/3 o. 4/6 (66%)',
        'col-6' => '1/2 (50%)',
        'col-4' => '1/3 (33%)',
        'col-3' => '1/4 (25%)',
        'col-2' => '1/6 (16%)',
    );
    $sizes_desktop = array(
        '' => 'Default',
        'col-lg-12' => '1/1 (100%)',
        'col-lg-10' => '5/6 (83%)',
        'col-lg-9' => '3/4 (75%)',
        'col-lg-8' => '2/3 o. 4/6 (66%)',
        'col-lg-6' => '1/2 (50%)',
        'col-lg-4' => '1/3 (33%)',
        'col-lg-3' => '1/4 (25%)',
        'col-lg-2' => '1/6 (16%)',
    );;
}

$colors_variants = array(
    '' => 'Default',
    'primary' => 'primary',
    'secondary' => 'secondary',
    'success' => 'success',
    'danger' => 'danger',
    'warning' => 'warning',
    'info' => 'info',
    'light' => 'light',
    'dark' => 'dark',
    'muted' => 'muted',
    'white' => 'white',
);

$imagePositions = array(
    '' => 'Default (zentriert)',
    'left top' => 'Links oben',
    'center top' => 'Mitte oben',
    'right top' => 'Rechts oben',
    'left center' => 'Links zentriert',
    'right center' => 'Rechts zentriert',
    'left bottom' => 'Links unten',
    'center bottom' => 'Mitte unten',
    'right bottom' => 'Rechts unten',
);
$text_aligns = array(
    'text-left' => 'left',
    'text-center' => 'center',
    'text-right' => 'right'
);

/****************************************************************
 *   GRID SYSTEM
 ****************************************************************/

$theme_palette = "{theme_legend},text_color,background_color,addBackgroundImage," . ($USE_COLORTHEME ? ",color_theme" : "") . ";";
$grid_palette = "{grid_legend},margin,grid,grid_visible,grid_mobile,grid_mobile_visible,grid_horizontal_align,grid_vertical_align" . ($USE_PARALLAX ? ",is_parallax,parallax_z" : "") . ";{margin_legend},vertical_align,margin_top,margin_bottom;";


foreach ($GLOBALS['TL_DCA']['tl_content']['palettes'] as $palette => $content):
    if (is_string($content)):
        $GLOBALS['TL_DCA']['tl_content']['palettes'][$palette] = preg_replace('/;{template_legend/', ';' . $theme_palette . $grid_palette . '{template_legend', $content);
    endif;
endforeach;
$GLOBALS['TL_DCA']['tl_content']['fields']['padding'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['padding'],
    'exclude' => true,
    'inputType' => 'trbl',
    'options' => $GLOBALS['TL_CSS_UNITS'],
    'eval' => array('includeBlankOption' => true, 'tl_class' => 'w50'),
    'sql' => "varchar(128) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_content']['fields']['margin'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['margin'],
    'exclude' => true,
    'inputType' => 'trbl',
    'options' => $GLOBALS['TL_CSS_UNITS'],
    'eval' => array('includeBlankOption' => true, 'tl_class' => 'w50'),
    'sql' => "varchar(128) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_content']['fields']['grid'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['grid'],
    'search' => true,
    'inputType' => 'select',
    'options' => $sizes_desktop,
    'eval' => array('includeBlankOption' => true, 'mandatory' => false, 'tl_class' => 'w50 clr'),
    'sql' => "varchar(24) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_content']['fields']['grid_visible'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['grid_visible'],
    'default' => 1,
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => array('tl_class' => 'w50'),
    'sql' => "char(1) NOT NULL default '1'"
);
$GLOBALS['TL_DCA']['tl_content']['fields']['grid_mobile'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['grid_mobile'],
    'search' => true,
    'inputType' => 'select',
    'options' => $sizes,
    'eval' => array('includeBlankOption' => true, 'mandatory' => false, 'tl_class' => 'w50 clr'),
    'sql' => "varchar(16) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_content']['fields']['grid_mobile_visible'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['grid_mobile_visible'],
    'default' => 1,
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => array('tl_class' => 'w50'),
    'sql' => "char(1) NOT NULL default '1'"
);
$GLOBALS['TL_DCA']['tl_content']['fields']['grid_vertical_align'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['grid_vertical_align'],
    'search' => true,
    'inputType' => 'select',
    'options' => $verticalAlignment,
    'eval' => array('includeBlankOption' => true, 'mandatory' => false, 'tl_class' => 'w50 clr'),
    'sql' => "varchar(24) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_content']['fields']['grid_horizontal_align'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['grid_horizontal_align'],
    'search' => true,
    'inputType' => 'select',
    'options' => $horizontalAlignment,
    'eval' => array('includeBlankOption' => true, 'mandatory' => false, 'tl_class' => 'w50 clr'),
    'sql' => "varchar(24) NOT NULL default ''"
);
if ($USE_COLORTHEME) {
    $GLOBALS['TL_DCA']['tl_content']['fields']['color_theme'] = array(
        'label' => &$GLOBALS['TL_LANG']['tl_content']['color_theme'],
        'exclude' => true,
        'inputType' => 'select',
        'options' => array(
            'juicy' => 'Juicy Theme',
            'slate' => 'Spicy Slate Theme',
            'spicy' => 'Spicy Theme'
        ),
        'eval' => array('includeBlankOption' => true, 'tl_class' => 'w50'),
        'sql' => "varchar(5)"
    );
}
if ($USE_PARALLAX) {
    $GLOBALS['TL_DCA']['tl_content']['fields']['is_parallax'] = array(
        'label' => &$GLOBALS['TL_LANG']['tl_content']['is_parallax'],
        'exclude' => true,
        'inputType' => 'checkbox',
        'eval' => array('tl_class' => 'w50 clr'),
        'sql' => "char(1) NOT NULL default '0'"
    );
    $GLOBALS['TL_DCA']['tl_content']['fields']['parallax_z'] = array(
        'label' => &$GLOBALS['TL_LANG']['tl_content']['parallax_z'],
        'exclude' => true,
        'inputType' => 'text',
        'eval' => ['maxlength' => 4, 'tl_class' => 'w50'],
        'sql' => "varchar(4) NOT NULL default '0'"
    );
}
// Slider extension
$GLOBALS['TL_DCA']['tl_content']['fields']['sliderImplementation'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['sliderImplementation'],
    'default' => 0,
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => array('tl_class' => 'w50 clr'),
    'sql' => "char(1) NOT NULL default '1'"
);

// TEXT ALIGNMENT
$GLOBALS['TL_DCA']['tl_content']['fields']['headline_align'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['headline_align'],
    'exclude' => true,
    'inputType' => 'select',
    'options' => $text_aligns,
    'eval' => array('tl_class' => 'w50'),
    'sql' => "varchar(11) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_content']['fields']['text_align'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['text_align'],
    'exclude' => true,
    'inputType' => 'select',
    'options' => $text_aligns,
    'eval' => array('tl_class' => 'w50'),
    'sql' => "varchar(11) NOT NULL default ''"
);


// COLOR HANDLING
$GLOBALS['TL_DCA']['tl_content']['fields']['text_color'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['text_color'],
    'exclude' => true,
    'inputType' => 'select',
    'options' => $colors_variants,
    'eval' => array('tl_class' => 'clr w50'),
    'sql' => "varchar(9) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_content']['fields']['background_color'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['background_color'],
    'exclude' => true,
    'inputType' => 'select',
    'options' => $colors_variants,
    'eval' => array('tl_class' => 'w50'),
    'sql' => "varchar(9) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_content']['fields']['addBackgroundImage'] = $GLOBALS['TL_DCA']['tl_content']['fields']['addImage'];
$GLOBALS['TL_DCA']['tl_content']['fields']['addBackgroundImage']['eval']['tl_class'] = 'clr w100';
$GLOBALS['TL_DCA']['tl_content']['fields']['backgroundSize'] = $GLOBALS['TL_DCA']['tl_content']['fields']['size'];
$GLOBALS['TL_DCA']['tl_content']['fields']['backgroundSingleSRC'] = $GLOBALS['TL_DCA']['tl_content']['fields']['singleSRC'];
if ($USE_BACKGROUND_SKEW) {
    $GLOBALS['TL_DCA']['tl_content']['fields']['backgroundSkew'] = array(
        'label' => &$GLOBALS['TL_LANG']['tl_content']['backgroundSkew'],
        'default' => 0,
        'inputType' => 'checkbox',
        'eval' => array('tl_class' => 'w50')
    );
};
$GLOBALS['TL_DCA']['tl_content']['fields']['backgroundPosition'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['backgroundPosition'],
    'inputType' => 'select',
    'options' => $imagePositions,
    'default' => '',
    'eval' => array('tl_class' => 'w50 clr'),
    'sql' => "varchar(13) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['addBackgroundImage'] = 'backgroundSingleSRC,backgroundSize,backgroundPosition' . ($USE_BACKGROUND_SKEW ? ",backgroundSkew" : "");
array_push($GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'], "addBackgroundImage");


$GLOBALS['TL_DCA']['tl_content']['palettes']['sliderStart'] = str_replace(',sliderContinuous;', ',sliderContinuous,sliderImplementation;', $GLOBALS['TL_DCA']['tl_content']['palettes']['sliderStart']);

$GLOBALS['TL_DCA']['tl_content']['palettes']['headline'] = str_replace('headline;', 'headline,headline_align;', $GLOBALS['TL_DCA']['tl_content']['palettes']['headline']);
$GLOBALS['TL_DCA']['tl_content']['palettes']['text'] = str_replace('headline;', 'headline,headline_align;', $GLOBALS['TL_DCA']['tl_content']['palettes']['text']);
$GLOBALS['TL_DCA']['tl_content']['palettes']['text'] = str_replace('text;', 'text,text_align;', $GLOBALS['TL_DCA']['tl_content']['palettes']['text']);
