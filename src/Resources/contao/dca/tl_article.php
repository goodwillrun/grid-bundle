<?php
/****************************************************************
 *   BACKGROUND SYSTEM
 ****************************************************************/
$GLOBALS['TL_DCA']['tl_article']['fields']['background_color'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_article']['background_color'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['maxlength' => 6, 'multiple' => false, 'colorpicker' => true, 'isHexColor' => true, 'decodeEntities' => true, 'tl_class' => 'w50 wizard'],
    'sql' => "varchar(64) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_article']['fields']['background_image_SRC'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_article']['background_image'],
    'exclude' => true,
    'inputType' => 'fileTree',
    'eval' => array('filesOnly' => true, 'fieldType' => 'radio', 'mandatory' => false, 'tl_class' => 'w50', 'extensions' => \Contao\Config::get('validImageTypes')),
    'sql' => "blob NULL"
);
$GLOBALS['TL_DCA']['tl_article']['fields']['background_image_skew'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_article']['background_image_skew'],
    'default' => 0,
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => array('submitOnChange' => true, 'tl_class' => 'w50 clr'),
    'sql' => "char(1) NOT NULL default '0'"
);
$GLOBALS['TL_DCA']['tl_article']['fields']['background_settings'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_article']['background_settings'],
    'exclude' => true,
    'inputType' => 'select',
    'options' => array(
        'cover' => 'Bild ueber gesamtes Element',
        'center' => 'Bild Zentrieren',
        'repeat' => 'Bild wiederholen',
        'parallax' => 'Parallax Effekt',
    ),
    'reference' => &$GLOBALS['TL_LANG']['GWR']['options_background_settings'],
    'eval' => array('includeBlankOption' => true, 'tl_class' => 'w50'),
    'sql' => "varchar(12) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_article']['fields']['is_container'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_article']['is_container'],
    'default' => 0,
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => array('submitOnChange' => true, 'tl_class' => 'w50 clr'),
    'sql' => "char(1) NOT NULL default '0'"
);
$GLOBALS['TL_DCA']['tl_article']['fields']['no_gutters'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_article']['no_gutters'],
    'default' => 0,
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => array('submitOnChange' => true, 'tl_class' => 'w50 clr'),
    'sql' => "char(1) NOT NULL default '0'"
);
$GLOBALS['TL_DCA']['tl_article']['fields']['is_container_custom'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_article']['is_container_custom'],
    'default' => 0,
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => array('submitOnChange' => true, 'tl_class' => 'w50 clr'),
    'sql' => "char(1) NOT NULL default '0'"
);
$GLOBALS['TL_DCA']['tl_article']['fields']['container_max_width'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_article']['container_max_width'],
    'exclude' => true,
    'options' => $GLOBALS['TL_CSS_UNITS'],
    'inputType' => 'inputUnit',
    'eval' => ['includeBlankOption' => true, 'rgxp' => 'digit_auto_inherit', 'maxlength' => 20, 'tl_class' => 'w50'],
    'sql' => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_article']['fields']['padding'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_article']['padding'],
    'exclude' => true,
    'inputType' => 'trbl',
    'options' => $GLOBALS['TL_CSS_UNITS'],
    'eval' => array('includeBlankOption' => true, 'tl_class' => 'w50'),
    'sql' => "varchar(128) NOT NULL default ''"
);

/** CUSTOM */
$GLOBALS['TL_DCA']['tl_article']['fields']['color_theme'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_article']['color_theme'],
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
$GLOBALS['TL_DCA']['tl_article']['fields']['min_height'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_article']['min_height'],
    'default' => 0,
    'exclude' => true,
    'options' => $GLOBALS['TL_CSS_UNITS'],
    'inputType' => 'inputUnit',
    'eval' => ['includeBlankOption' => true, 'rgxp' => 'digit_auto_inherit', 'maxlength' => 20, 'tl_class' => 'w50'],
    'sql' => "varchar(64) NOT NULL default ''"
);
/** END CUSTOM **/

$GLOBALS['TL_DCA']['tl_article']['palettes']['__selector__'][] = 'is_container';
$GLOBALS['TL_DCA']['tl_article']['palettes']['__selector__'][] = 'is_container_custom';
$GLOBALS['TL_DCA']['tl_article']['subpalettes']['is_container'] = 'is_container_custom';
$GLOBALS['TL_DCA']['tl_article']['subpalettes']['is_container_custom'] = 'container_max_width';
$GLOBALS['TL_DCA']['tl_article']['palettes']['default'] = preg_replace('/,author;/', ',author;{container_legend},min_height,is_container,no_gutters,padding;{theme_legend},color_theme;{background_legend},background_color,background_image_SRC,background_image_skew,background_settings;', $GLOBALS['TL_DCA']['tl_article']['palettes']['default']);
