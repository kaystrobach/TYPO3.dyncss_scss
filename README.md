# TYPO3.dyncss_scss
Dyncss adapter for scss (not sass!)

Please see https://github.com/kaystrobach/TYPO3.dyncss for more documentation.

This extension just provides the adapter for the scss file format: every `*.scss` file added to the page renderer is
compiled to CSS.

```typoscript
page.includeCSS.theme = EXT:my_theme/Resources/Private/Scss/theme.scss
```

Variables can be overridden with `plugin.tx_dyncss.overrides`, see the README of dyncss.

## Requirements

TYPO3 12.4, 13.4 or 14 and dyncss from the branch `typo3-12-13-14` (branch `typo3-12-13-14` of this extension).

## Compiler

[scssphp](https://scssphp.github.io/scssphp/) 1.10 or later, also 2.x, installed via composer. Without composer the
bundled copy (`Resources/Private/Php/scssphp`) is used.

## Imports between extensions (composer mode)

Imports written for the classic layout below `typo3conf/ext/` are resolved in composer mode as well, also partials
(`_mixins.scss`):

```scss
@import "../../../../my_base_theme/Resources/Private/Scss/variables";
@import "../../../../my_base_theme/Resources/Private/Scss/mixins";
```

The first folder after the `../` is taken as extension key (`KayStrobach\Dyncss\Utilities\LegacyExtensionPath` of
dyncss).

## Errors

A scss error does not break the page: the generated stylesheet contains the error message as comment.

## Tests

Functional tests in docker against TYPO3 12, 13 and 14, with the dyncss clone next to this one (`../dyncss`, otherwise
the branch `typo3-12-13-14` from GitHub):

    Build/Scripts/runTests.sh -t 12             # TYPO3 12, also 13 or 14, scssphp 1.x
    SCSSPHP=2 Build/Scripts/runTests.sh -t 12   # with scssphp 2.x
    Build/Scripts/runTests.sh -a                # all versions
