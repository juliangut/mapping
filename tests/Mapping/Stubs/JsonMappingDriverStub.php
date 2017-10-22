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

use Jgut\Mapping\Driver\Traits\JsonMappingTrait;

/**
 * JSON file mapping driver stub.
 */
class JsonMappingDriverStub
{
    use JsonMappingTrait {
        getExtensions as originalGetExtensions;
        loadMappingFile as originalLoadMappingFile;
    }

    /**
     * Get supported mapping file extensions.
     *
     * @return string[]
     */
    public function getExtensions(): array
    {
        return $this->originalGetExtensions();
    }

    /**
     * Load mappings from file.
     *
     * @param string $mappingFile
     *
     * @return array
     */
    public function loadMappingFile(string $mappingFile): array
    {
        return $this->originalLoadMappingFile($mappingFile);
    }
}
