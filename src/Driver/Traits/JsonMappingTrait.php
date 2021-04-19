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

use Jgut\Mapping\Exception\DriverException;

/**
 * JSON file mapping trait.
 */
trait JsonMappingTrait
{
    /**
     * Get supported mapping file extensions.
     *
     * @return string[]
     */
    protected function getExtensions(): array
    {
        return ['json'];
    }

    /**
     * Load mappings from file.
     *
     * @param string $mappingFile
     *
     * @throws DriverException
     *
     * @return array
     */
    protected function loadMappingFile(string $mappingFile): array
    {
        $mappingData = \json_decode(\file_get_contents($mappingFile), true, 512, \JSON_BIGINT_AS_STRING);

        if (\json_last_error() !== \JSON_ERROR_NONE) {
            throw new DriverException(
                \sprintf('JSON mapping file "%s" parsing error: %s.', $mappingFile, \rtrim(\json_last_error_msg(), '.'))
            );
        }

        return $mappingData;
    }
}
