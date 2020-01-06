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

namespace Jgut\Mapping\Metadata;

use Jgut\Mapping\Driver\DriverFactoryInterface;
use Psr\SimpleCache\CacheInterface;

/**
 * Metadata resolver.
 */
class MetadataResolver
{
    /**
     * Driver factory.
     *
     * @var DriverFactoryInterface
     */
    protected $driverFactory;

    /**
     * Metadata cache.
     *
     * @var CacheInterface|null
     */
    protected $cache;

    /**
     * MetadataResolver constructor.
     *
     * @param DriverFactoryInterface $driverFactory
     * @param CacheInterface         $cache
     */
    public function __construct(DriverFactoryInterface $driverFactory, CacheInterface $cache = null)
    {
        $this->driverFactory = $driverFactory;
        $this->cache = $cache;
    }

    /**
     * Get metadata.
     *
     * @param mixed[] $mappingSources
     *
     * @return MetadataInterface[]
     */
    public function getMetadata(array $mappingSources): array
    {
        $mappingSources = $this->normalizeMappingSources($mappingSources);

        $cacheKey = $this->getCacheKey($mappingSources);

        if ($this->cache !== null && $this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $metadata = \array_map(
            function (array $mappingSource): array {
                return $this->driverFactory->getDriver($mappingSource)->getMetadata();
            },
            $mappingSources
        );
        $metadata = \count($metadata) > 0 ? \array_merge(...$metadata) : [];

        if ($this->cache !== null) {
            $this->cache->set($cacheKey, $metadata);
        }

        return $metadata;
    }

    /**
     * Get cache key.
     *
     * @param mixed[] $mappingSources
     *
     * @return string
     */
    protected function getCacheKey(array $mappingSources): string
    {
        return \implode(
            '.',
            \array_map(
                function (array $mappingSource): string {
                    $path = \is_array($mappingSource['path'])
                        ? \implode('', $mappingSource['path'])
                        : $mappingSource['path'];

                    return $mappingSource['type'] . '.' . $path;
                },
                $mappingSources
            )
        );
    }

    /**
     * Normalize mapping sources format.
     *
     * @param mixed[] $mappingSources
     *
     * @return string[][]
     */
    protected function normalizeMappingSources(array $mappingSources): array
    {
        return \array_map(
            function ($mappingSource): array {
                if (!\is_array($mappingSource)) {
                    $mappingSource = [
                        'type' => DriverFactoryInterface::DRIVER_ANNOTATION,
                        'path' => $mappingSource,
                    ];
                }

                return $mappingSource;
            },
            $mappingSources
        );
    }
}
