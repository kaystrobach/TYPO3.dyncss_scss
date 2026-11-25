<?php

declare(strict_types=1);

namespace KayStrobach\DyncssScss\Tests\Functional;

use KayStrobach\Dyncss\Configuration\BeRegistry;
use KayStrobach\DyncssScss\Parser\ScssParser;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Runs with scssphp 1.x and 2.x (SCSSPHP=2 Build/Scripts/runTests.sh).
 */
class ScssParserTest extends FunctionalTestCase
{
    protected array $coreExtensionsToLoad = ['install'];

    protected array $testExtensionsToLoad = [
        'typo3conf/ext/dyncss',
        'typo3conf/ext/dyncss_scss',
        __DIR__ . '/Fixtures/Extensions/dyncss_scss_fixture_importer',
        __DIR__ . '/Fixtures/Extensions/dyncss_scss_fixture_imported',
    ];

    protected function tearDown(): void
    {
        GeneralUtility::rmdir(Environment::getPublicPath() . '/typo3temp/assets/DynCss', true);
        GeneralUtility::rmdir(Environment::getPublicPath() . '/typo3temp/DynCss', true);
        parent::tearDown();
    }

    private function compile(string $file, array $overrides = []): string
    {
        $parser = new ScssParser();
        $parser->setOverrides($overrides);
        $compiledFile = $parser->compileFile(ExtensionManagementUtility::extPath('dyncss_scss_fixture_importer') . 'Resources/Private/Scss/' . $file);
        self::assertFileExists($compiledFile);
        return (string)file_get_contents($compiledFile);
    }

    public function testParserIsRegisteredForScssFiles(): void
    {
        self::assertInstanceOf(ScssParser::class, BeRegistry::get()->getFileHandler('scss'));
    }

    public function testImportsOfAnotherExtensionWrittenForTypo3confExtAreResolved(): void
    {
        $css = $this->compile('style.scss');
        self::assertMatchesRegularExpression('/\.text\s*\{\s*color:\s*#123456;\s*border-radius:\s*4px;?\s*\}/', $css, 'file and partial');
        self::assertMatchesRegularExpression('/\.local\s*\{\s*margin:\s*0;?\s*\}/', $css, 'import relative to the file');
    }

    public function testOverridesReplaceVariables(): void
    {
        $css = $this->compile('style.scss', ['text-color' => '#abcdef']);
        self::assertStringContainsString('#abcdef', $css);
        self::assertStringNotContainsString('#123456', $css);
    }

    public function testErrorsEndUpAsCommentInTheStylesheet(): void
    {
        $css = $this->compile('broken.scss');
        self::assertStringStartsWith('/* ', $css);
        self::assertStringContainsString('Undefined variable', $css);
    }

    public function testStringIsCompiled(): void
    {
        $css = (new ScssParser())->compile('$a: 2px; .b { width: $a * 2; }');
        self::assertMatchesRegularExpression('/\.b\s*\{\s*width:\s*4px;?\s*\}/', $css);
    }

    public function testVersionOfTheCompiler(): void
    {
        self::assertMatchesRegularExpression('/^v?\d+\.\d+/', (new ScssParser())->getVersion());
    }
}
