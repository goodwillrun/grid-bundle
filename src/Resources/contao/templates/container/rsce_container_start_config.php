<?php
return array(
    'label' => array('Container Start', 'Creates a container'),
    'types' => array('content'),
    'contentCategory' => 'Layout',
    'standardFields' => array('cssID'),
    'wrapper' => array(
        'type' => 'start',
    ),
    'fields' => array(
        'fluid' => array(
            'label' => array('is fluid', 'Let the container use the whole width of the screen'),
            'inputType' => 'checkbox',
        ),
    )
);
