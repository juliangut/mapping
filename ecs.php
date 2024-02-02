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
use Symplify\EasyCodingStandard\Config\ECSConfig;

$configSet = (new ConfigSet80())
    ->setHeader(<<<'HEADER'
    (c) 2017-{{year}} Julián Gutiérrez <juliangut@gmail.com>

    @license BSD-3-Clause
    @link https://github.com/juliangut/mapping
    HEADER)
    ->enablePhpUnitRules()
    ->setAdditionalSkips([
        NoSilencedErrorsSniff::class . '.Forbidden' => [
            __DIR__ . '/src/Driver/AbstractAnnotationDriver.php', // Temporal while deprecating annotations
        ],
    ]);
$paths = [
    __FILE__,
    __DIR__ . '/src',
    __DIR__ . '/tests',
];

if (!method_exists(ECSConfig::class, 'configure')) {
    return static function (ECSConfig $ecsConfig) use ($configSet, $paths): void {
        $ecsConfig->paths($paths);
        $ecsConfig->cacheDirectory('.ecs.cache');

        $configSet->configure($ecsConfig);
    };
}

return $configSet
    ->configureBuilder()
    ->withCache('.ecs.cache')
    ->withPaths($paths);
