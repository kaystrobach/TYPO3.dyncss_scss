<?php

class tx_DyncssScss_ParserCompass extends tx_DyncssScss_Parser {
	function __construct() {
		parent::__construct();
		if(!class_exists('scss_compass')) {
			include_once(t3lib_extMgm::extPath('dyncss_scss') . 'Resources/Private/Php/scss_compass/compass.inc.php');
		}
		new scss_compass($this->parser);
	}
}
