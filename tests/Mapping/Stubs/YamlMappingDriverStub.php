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

namespace Jgut\Mapping\Tests\Stubs;

use Jgut\Mapping\Driver\DriverInterface;
use Jgut\Mapping\Driver\Traits\YamlMappingTrait;

/**
 * @internal
 */
class YamlMappingDriverStub implements DriverInterface
{
    use YamlMappingTrait {
        getExtensions as originalGetExtensions;
        loadMappingFile as originalLoadMappingFile;
    }

    /**
     * Get supported mapping file extensions.
     *
     * @return array<string>
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
