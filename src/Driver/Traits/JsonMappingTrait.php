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
use JsonException;

trait JsonMappingTrait
{
    protected function getExtensions(): array
    {
        return ['json'];
    }

    protected function loadMappingFile(string $mappingFile): array
    {
        try {
            $mappingData = json_decode(
                file_get_contents($mappingFile),
                true,
                512,
                \JSON_BIGINT_AS_STRING | \JSON_THROW_ON_ERROR,
            );
        } catch (JsonException $exception) {
            throw new DriverException(
                sprintf('JSON mapping file "%s" parsing error: %s.', $mappingFile, $exception->getMessage()),
                0,
                $exception,
            );
        }

        return $mappingData;
    }
}
