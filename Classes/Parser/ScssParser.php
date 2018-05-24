<?php

namespace KayStrobach\DyncssScss\Parser;

use KayStrobach\Dyncss\Utilities\ApplicationContext;

class ScssParser extends \KayStrobach\Dyncss\Parser\AbstractParser
{
    public function __construct()
    {
        parent::__construct();
        // ensure no one else has loaded lessc already ;)
        if (!defined('TYPO3_COMPOSER_MODE') || !TYPO3_COMPOSER_MODE) {
            if (!class_exists('\Leafo\ScssPhp\Compiler')) {
                include_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('dyncss_scss') . 'Resources/Private/Php/scss/scss.inc.php');
            }
        }
        // build instance to usage
        $this->parser = new \Leafo\ScssPhp\Compiler();
    }
    /**
     * @param $string
     * @param null $name
     * @return mixed
     */
    protected function _compile($string, $name = null)
    {
        // TODO: Implement _compile() method.
    }

    /**
     * @param $string
     * @return mixed
     */
    protected function _prepareCompile($string)
    {
        return $string;
    }

    /**
     * @param $inputFilename
     * @param $outputFilename
     * @param $cacheFilename
     */
    protected function _compileFile($inputFilename, $preparedFilename, $outputFilename, $cacheFilename)
    {
        try {
            $this->parser->setVariables($this->overrides);
            $this->parser->setImportPaths(array(dirname($inputFilename), dirname($preparedFilename)));
            if (ApplicationContext::isDevelopmentModeActive() || $this->config['enableDebugMode'] === '1') {
                $this->parser->setSourceMap(\Leafo\ScssPhp\Compiler::SOURCE_MAP_FILE);
                $this->parser->setSourceMapOptions(array(
                    'sourceMapWriteTo'  => $preparedFilename . ".map",
                    'sourceMapURL'      => '/' . str_replace(PATH_site, '', $preparedFilename) . ".map",
                    'sourceMapFilename' => '/'  . $preparedFilename,  // url location of .css file
                    'sourceMapBasepath' => PATH_site,  // difference between file & url locations, removed from ALL source files in .map
                    'sourceRoot'        => '/',
                ));
            }
            return $this->parser->compile('@import "' . basename($preparedFilename) . '"');
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return \Leafo\ScssPhp\Version::VERSION;
    }

    /**
     * returns the homepage of the parser
     * @return string
     */
    public function getParserHomepage()
    {
        return 'http://leafo.github.io/scssphp';
    }

    /**
     * return readable name of the project
     * @return string
     */
    public function getParserName()
    {
        return 'scssphp';
    }
}
