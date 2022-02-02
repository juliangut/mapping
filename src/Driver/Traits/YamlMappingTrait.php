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
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml as YamlReader;

/**
 * YAML file mapping trait.
 */
trait YamlMappingTrait
{
    /**
     * @inheritDoc
     */
    protected function getExtensions(): array
    {
        return ['yml', 'yaml'];
    }

    /**
     * Load mappings from file.
     *
     * @throws DriverException
     */
    protected function loadMappingFile(string $mappingFile): array
    {
        try {
            $mappings = YamlReader::parse(
                file_get_contents($mappingFile),
                YamlReader::PARSE_EXCEPTION_ON_INVALID_TYPE,
            );
            // @codeCoverageIgnoreStart
        } catch (ParseException $exception) {
            throw new DriverException(
                sprintf('YAML mapping file "%s" parsing error: %s.', $mappingFile, rtrim($exception->getMessage())),
                0,
                $exception,
            );
        }
        // @codeCoverageIgnoreEnd

        return $mappings;
    }
}
