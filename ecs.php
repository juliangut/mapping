<?php

/*
 * (c) 2017-2024 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/mapping
 */

declare(strict_types=1);

use Jgut\ECS\Config\ConfigSet80;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\NoSilencedErrorsSniff;
use PhpCsFixer\Fixer\Basic\BracesFixer;
use PhpCsFixer\Fixer\Basic\CurlyBracesPositionFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassDefinitionFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

$skips = [
    NoSilencedErrorsSniff::class . '.Forbidden' => [
        __DIR__ . '/src/Driver/AbstractAnnotationDriver.php', // Temporal while deprecating annotations
    ],
];
if (\PHP_VERSION_ID < 80_200) {
    $skips[CurlyBracesPositionFixer::class] = __DIR__ . '/src/Metadata/MetadataInterface.php';
    $skips[BracesFixer::class] = __DIR__ . '/src/Metadata/MetadataInterface.php';
    $skips[ClassDefinitionFixer::class] = __DIR__ . '/src/Metadata/MetadataInterface.php';
}

$configSet = (new ConfigSet80())
    ->setHeader(<<<'HEADER'
    (c) 2017-{{year}} Julián Gutiérrez <juliangut@gmail.com>

    @license BSD-3-Clause
    @link https://github.com/juliangut/mapping
    HEADER)
    ->enablePhpUnitRules()
    ->setAdditionalSkips($skips);
$paths = [
    __FILE__,
    __DIR__ . '/src',
    __DIR__ . '/tests',
];

if (!method_exists(ECSConfig::class, 'configure')) {
    return static function (ECSConfig $ecsConfig) use ($configSet, $paths): void {
        $ecsConfig->paths($paths);

        $configSet->configure($ecsConfig);
    };
}

return $configSet
    ->configureBuilder()
    ->withPaths($paths);
