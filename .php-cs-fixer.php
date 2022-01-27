<?php

/*
 * mapping (https://github.com/juliangut/mapping).
 * Mapping parsing base library.
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/mapping
 * @author Julián Gutiérrez <juliangut@gmail.com>
 */

declare(strict_types=1);

use Jgut\CS\Fixer\FixerConfig74;
use PhpCsFixer\Finder;

$header = <<<'HEADER'
mapping (https://github.com/juliangut/mapping).
Mapping parsing base library.

@license BSD-3-Clause
@link https://github.com/juliangut/mapping
@author Julián Gutiérrez <juliangut@gmail.com>
HEADER;

$finder = Finder::create()
    ->ignoreDotFiles(false)
    ->exclude(['build', 'vendor'])
    ->in(__DIR__)
    ->name('.php-cs-fixer.php');

return (new FixerConfig74())
    ->setHeader($header)
    ->enablePhpUnitRules()
    ->setAdditionalRules([
        'native_constant_invocation' => [
            'strict' => version_compare(\PHP_VERSION, '8.0.0') >= 0,
        ],
    ])
    ->setFinder($finder);
