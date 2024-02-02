<?php

/*
 * (c) 2017-2024 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/mapping
 */

declare(strict_types=1);

namespace Jgut\Mapping\Driver\Traits;

use Jgut\Mapping\Exception\DriverException;

trait PhpMappingTrait
{
    protected function getExtensions(): array
    {
        return ['php'];
    }

    protected function loadMappingFile(string $mappingFile): array
    {
        $mappings = require $mappingFile;

        if (!\is_array($mappings)) {
            throw new DriverException(sprintf('Malformed XML mapping file "%s".', $mappingFile), 0);
        }

        return $mappings;
    }
}
