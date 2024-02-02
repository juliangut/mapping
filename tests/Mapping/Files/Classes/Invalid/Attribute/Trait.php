<?php

/*
 * (c) 2017-2024 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/mapping
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
