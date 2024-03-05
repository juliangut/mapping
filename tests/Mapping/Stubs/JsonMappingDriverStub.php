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
use Jgut\Mapping\Driver\Traits\JsonMappingTrait;

/**
 * @internal
 */
class JsonMappingDriverStub implements DriverInterface
{
    use JsonMappingTrait {
        getExtensions as originalGetExtensions;
        loadMappingFile as originalLoadMappingFile;
    }

    /**
     * Get supported mapping file extensions.
     *
     * @return list<string>
     */
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
