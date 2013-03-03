<?php

$scssParserConfig = unserialize($TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY]);

if((!array_key_exists('parser', $scssParserConfig)) || ($scssParserConfig['parser'] === 'php')) {
	tx_DynCss_Configuration_BeRegistry::get()->registerFileHandler('scss', 'tx_DyncssScss_Parser');
} elseif($scssParserConfig['parser'] === 'compass') {
	tx_DynCss_Configuration_BeRegistry::get()->registerFileHandler('scss', 'tx_DyncssScss_ParserCompass');
} else {
	// mmhm misconfiguration, no parser at all ;)
}

unset($scssParserConfig);
