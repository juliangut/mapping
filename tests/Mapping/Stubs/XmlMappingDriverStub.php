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
use Jgut\Mapping\Driver\Traits\XmlMappingTrait;

/**
 * @internal
 */
class XmlMappingDriverStub implements DriverInterface
{
    use XmlMappingTrait {
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
