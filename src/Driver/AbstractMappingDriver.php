<?php

/*
 * (c) 2017-2024 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/mapping
 */

declare(strict_types=1);

namespace Jgut\Mapping\Driver;

use Jgut\Mapping\Exception\DriverException;

abstract class AbstractMappingDriver extends AbstractDriver
{
    /**
     * @throws DriverException
     *
     * @return array<int|string, mixed>
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
     * @throws DriverException
     *
     * @return array<int|string, mixed>
     */
    abstract protected function loadMappingFile(string $mappingFile): array;

    /**
     * @param array<int|string, mixed|array<int|string, mixed>> $mappingsA
     * @param array<int|string, mixed|array<int|string, mixed>> $mappingsB
     *
     * @return array<int|string, mixed>
     */
    final protected function mergeMappings(array $mappingsA, array $mappingsB): array
    {
        foreach ($mappingsB as $key => $value) {
            if (\array_key_exists($key, $mappingsA) || \array_key_exists($key, $mappingsA)) {
                if (\is_int($key)) {
                    $mappingsA[] = $value;
                } elseif (\is_array($value) && \is_array($mappingsA[$key])) {
                    /** @var array<int|string, mixed> $valueA */
                    $valueA = $mappingsA[$key];
                    /** @var array<int|string, mixed> $value */
                    $mappingsA[$key] = $this->mergeMappings($valueA, $value);
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
