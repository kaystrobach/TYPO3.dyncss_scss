<?php

########################################################################
# Extension Manager/Repository config file for ext "less".
#
# Auto generated 09-03-2012 10:37
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF['dyncss_scss'] = [
    'title' => 'DynCss - SCSS Parser (based on Leafo SCSS-Parser v1.0.8)',
    'description' => 'DynCss-Parser',
    'category' => 'fe',
    'version' => '2.0.0',
    'state' => 'stable',
    'clearcacheonload' => 0,
    'author' => 'Kay Strobach',
    'author_email' => 'kay.strobach@typo3.org',
    'author_company' => '',
    'constraints' => [
        'depends' => [
            'dyncss' => '1.0.0-1.99.99',
            'typo3' => '12.4.0-14.9.99'
        ],
        'conflicts' => [
        ],
        'suggests' => [
        ],
    ],
];
