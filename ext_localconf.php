<?php

defined('TYPO3') || die('Access denied.');

\KayStrobach\Dyncss\Configuration\BeRegistry::get()->registerFileHandler('scss', \KayStrobach\DyncssScss\Parser\ScssParser::class);
