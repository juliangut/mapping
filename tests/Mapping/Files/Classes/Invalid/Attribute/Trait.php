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

namespace Jgut\Mapping\Tests\Files\Classes\Invalid\Attribute;

trait TraitA
{
    public function methodA(): void {}

    public function methodB(): void
    {
        $var = new class () {};
        echo $var::class;
    }
}