<?php

if (class_exists('\KayStrobach\Dyncss\Configuration\BeRegistry')) {
    \KayStrobach\Dyncss\Configuration\BeRegistry::get()->registerFileHandler('scss', 'KayStrobach\DyncssScss\Parser\ScssParser');
}
