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

namespace Jgut\Mapping\Driver;

/**
 * Abstract file based mapping driver.
 */
abstract class AbstractMappingDriver extends AbstractDriver
{
    /**
     * Get mapping data.
     *
     * @throws \Jgut\Mapping\Exception\DriverException
     *
     * @return mixed[]
     */
    protected function getMappingData(): array
    {
        $mappings = [];

        foreach ($this->locator->getMappingFiles() as $mappingFile) {
            $mappings[] = $this->loadMappingFile($mappingFile);
        }

        $mappingData = [];
        foreach ($mappings as $mapping) {
            $mappingData = $this->mergeMappings($mappingData, $mapping);
        }

        return $mappingData;
    }

    /**
     * Load mappings from file.
     *
     * @param string $mappingFile
     *
     * @return mixed[]
     */
    abstract protected function loadMappingFile(string $mappingFile): array;

    /**
     * Merge mapping data.
     *
     * @param mixed[] $mappingsA
     * @param mixed[] $mappingsB
     *
     * @return mixed[]
     */
    final protected function mergeMappings(array $mappingsA, array $mappingsB): array
    {
        foreach ($mappingsB as $key => $value) {
            if (isset($mappingsA[$key]) || \array_key_exists($key, $mappingsA)) {
                if (\is_int($key)) {
                    $mappingsA[] = $value;
                } elseif (\is_array($value) && \is_array($mappingsA[$key])) {
                    $mappingsA[$key] = $this->mergeMappings($mappingsA[$key], $value);
                } else {
                    $mappingsA[$key] = $value;
                }
            } else {
                $mappingsA[$key] = $value;
            }
        }

        return $mappingsA;
    }
}
