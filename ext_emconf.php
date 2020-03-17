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
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearcacheonload' => 0,
    'author' => 'Kay Strobach',
    'author_email' => 'kay.strobach@typo3.org',
    'author_company' => '',
    'CGLcompliance' => '',
    'CGLcompliance_note' => '',
    'constraints' => [
        'depends' => [
            'dyncss' => '1.0.0-1.99.99',
            'typo3' => '10.3.0-10.4.99'
        ],
        'conflicts' => [
        ],
        'suggests' => [
        ],
    ],
    '_md5_values_when_last_written' => 'a:11:{s:9:"ChangeLog";s:4:"dfaa";s:10:"README.txt";s:4:"ee2d";s:21:"ext_conf_template.txt";s:4:"1cbe";s:12:"ext_icon.gif";s:4:"6c2c";s:17:"ext_localconf.php";s:4:"e47e";s:28:"ext_typoscript_constants.txt";s:4:"f81f";s:24:"ext_typoscript_setup.txt";s:4:"e8b6";s:13:"locallang.xml";s:4:"13b4";s:23:"lib/lessc-0.2.0.inc.php";s:4:"efef";s:23:"lib/lessc-0.3.3.inc.php";s:4:"e18e";s:25:"pi1/class.tx_less_pi1.php";s:4:"6db7";}',
];
