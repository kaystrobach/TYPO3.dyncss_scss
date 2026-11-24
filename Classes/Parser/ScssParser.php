<?php

namespace KayStrobach\DyncssScss\Parser;

use KayStrobach\Dyncss\Parser\AbstractParser;
use KayStrobach\Dyncss\Utilities\LegacyExtensionPath;
use ScssPhp\ScssPhp\Compiler;
use ScssPhp\ScssPhp\ValueConverter;
use ScssPhp\ScssPhp\Version;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * Compiles *.scss files with scssphp (composer package scssphp/scssphp, otherwise the bundled copy).
 */
class ScssParser extends AbstractParser
{
    /**
     * @var Compiler
     */
    protected $parser;

    public function __construct()
    {
        parent::__construct();
        // the bundled scssphp, only if no other one is installed (e.g. without composer)
        if (!class_exists(Compiler::class)) {
            include_once ExtensionManagementUtility::extPath('dyncss_scss') . 'Resources/Private/Php/scssphp/scss.inc.php';
        }
        $this->parser = new Compiler();
    }

    /**
     * @param string $string
     * @param string|null $name
     * @return string
     */
    protected function _compile($string, $name = null)
    {
        return $this->compileSource((string)$string, [], $name);
    }

    /**
     * @param string $string
     * @return string
     */
    protected function _prepareCompile($string)
    {
        return $string;
    }

    /**
     * @param string $inputFilename
     * @param string $preparedFilename
     * @param string $outputFilename
     * @param string $cacheFilename
     * @return string
     */
    protected function _compileFile($inputFilename, $preparedFilename, $outputFilename, $cacheFilename)
    {
        return $this->compileSource(
            '@import "' . basename($preparedFilename) . '";',
            [dirname($inputFilename), dirname($preparedFilename)],
            $inputFilename
        );
    }

    /**
     * @param list<string> $importPaths
     */
    protected function compileSource(string $source, array $importPaths, ?string $path): string
    {
        try {
            $this->parser->setImportPaths($importPaths);
            // imports between extensions written for typo3conf/ext/ (composer mode), after the regular import paths
            $this->parser->addImportPath([self::class, 'resolveImport']);
            $this->parser->replaceVariables(array_map(
                static fn ($value) => ValueConverter::parseValue((string)$value),
                $this->overrides
            ));
            return $this->parser->compileString($source, $path)->getCss();
        } catch (\Exception $e) {
            // visible in the generated stylesheet instead of breaking the page
            return '/* ' . str_replace('*/', '* /', $e->getMessage()) . ' */';
        }
    }

    /**
     * Import path of scssphp for imports like "../../../../my_theme/Resources/Private/Scss/variables",
     * also as partial (_variables.scss).
     */
    public static function resolveImport(string $path): ?string
    {
        $file = LegacyExtensionPath::resolve($path, ['scss', 'css']);
        if ($file === null && str_contains($path, '/')) {
            $partial = dirname($path) . '/_' . basename($path);
            $file = LegacyExtensionPath::resolve($partial, ['scss']);
        }
        return $file;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return Version::VERSION;
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
