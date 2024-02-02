<?php

/*
 * (c) 2017-2024 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/mapping
 */

declare(strict_types=1);

namespace Jgut\Mapping\Tests\Stubs;

use Jgut\Mapping\Driver\DriverInterface;
use Jgut\Mapping\Driver\Traits\PhpMappingTrait;

/**
 * @internal
 */
class PhpMappingDriverStub implements DriverInterface
{
    use PhpMappingTrait {
        getExtensions as originalGetExtensions;
        loadMappingFile as originalLoadMappingFile;
    }

    public function getExtensions(): array
    {
        return $this->originalGetExtensions();
    }

    public function loadMappingFile(string $mappingFile): array
    {
        return $this->originalLoadMappingFile($mappingFile);
    }

    public function getMetadata(): array
    {
        return [new MetadataStub()];
    }
}
