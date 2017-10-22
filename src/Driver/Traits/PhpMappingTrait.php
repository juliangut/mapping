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

namespace Jgut\Mapping\Driver\Traits;

/**
 * PHP file mapping trait.
 */
trait PhpMappingTrait
{
    /**
     * Get supported mapping file extensions.
     *
     * @return string[]
     */
    protected function getExtensions(): array
    {
        return ['php'];
    }

    /**
     * Load mappings from file.
     *
     * @param string $mappingFile
     *
     * @return array
     */
    protected function loadMappingFile(string $mappingFile): array
    {
        return require $mappingFile;
    }
}
