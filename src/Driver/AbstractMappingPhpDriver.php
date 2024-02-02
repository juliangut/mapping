<?php

/*
 * (c) 2017-2024 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/mapping
 */

declare(strict_types=1);

namespace Jgut\Mapping\Driver;

use Jgut\Mapping\Driver\Traits\PhpMappingTrait;

abstract class AbstractMappingPhpDriver extends AbstractMappingDriver
{
    use PhpMappingTrait;
}
