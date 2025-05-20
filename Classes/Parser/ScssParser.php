<?php

namespace KayStrobach\DyncssScss\Parser;

use Exception;

class ScssParser extends \KayStrobach\Dyncss\Parser\AbstractParser
{

    /**
     * @var \ScssPhp\ScssPhp\Compiler
     */
    protected $parser;

    public function __construct()
    {
        parent::__construct();
        // ensure no one else has loaded lessc already ;)
        if (!defined('TYPO3_COMPOSER_MODE') || !TYPO3_COMPOSER_MODE) {
            if (!class_exists('\ScssPhp\ScssPhp\Compiler')) {
                include_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('dyncss_scss') . 'Resources/Private/Php/scssphp/scss.inc.php');
            }
        }
        // build instance to usage
        $this->parser = new \ScssPhp\ScssPhp\Compiler();
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
        return \ScssPhp\ScssPhp\Version::VERSION;
    }

    /**
     * returns the homepage of the parser
     * @return string
     */
    public function getParserHomepage()
    {
        return 'https://scssphp.github.io/scssphp/';
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
