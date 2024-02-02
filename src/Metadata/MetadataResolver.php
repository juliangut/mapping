<?php

/*
 * (c) 2017-2024 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/mapping
 */

declare(strict_types=1);

namespace Jgut\Mapping\Metadata;

use Jgut\Mapping\Driver\DriverFactoryInterface;
use Psr\SimpleCache\CacheInterface;

/**
 * @phpstan-type Source array{driver?: object, type?: string, path?: string|list<string>}
 */
class MetadataResolver
{
    protected string $cachePrefix = '';

    /**
     * @param CacheInterface<mixed>|null $cache
     */
    public function __construct(
        protected DriverFactoryInterface $driverFactory,
        protected ?CacheInterface $cache = null,
    ) {}

    public function setCachePrefix(string $cachePrefix): void
    {
        $this->cachePrefix = $cachePrefix;
    }

    /**
     * @param list<string|Source> $mappingSources
     *
     * @return list<MetadataInterface>
     */
    public function getMetadata(array $mappingSources): array
    {
        $mappingSources = $this->normalizeMappingSources($mappingSources);

        $cacheKey = $this->getCacheKey($mappingSources);

        if ($this->cache !== null && $this->cache->has($cacheKey)) {
            $cachedMetadata = $this->cache->get($cacheKey);

            if (\is_array($cachedMetadata)) {
                /** @var list<MetadataInterface> $cachedMetadata */
                return $cachedMetadata;
            }
        }

        $metadata = array_map(
            function (array $mappingSource): array {
                return $this->driverFactory->getDriver($mappingSource)
                    ->getMetadata();
            },
            $mappingSources,
        );
        $metadata = \count($metadata) > 0 ? array_merge(...$metadata) : [];

        $this->cache?->set($cacheKey, $metadata);

        return $metadata;
    }

    /**
     * Get cache key.
     *
     * @param list<Source> $mappingSources
     */
    protected function getCacheKey(array $mappingSources): string
    {
        $key = array_reduce(
            $mappingSources,
            static function (string $key, array $mappingSource): string {
                if (\array_key_exists('driver', $mappingSource)) {
                    return sprintf('%s::driver:%s', $key, $mappingSource['driver']::class);
                }

                /** @var array{type: string, path: string|list<string>} $mappingSource */
                $path = \is_array($mappingSource['path'])
                    ? implode('', $mappingSource['path'])
                    : $mappingSource['path'];

                return sprintf('%s::%s:%s', $key, $mappingSource['type'], $path);
            },
            'mapping',
        );

        return $this->cachePrefix . hash('sha256', $key);
    }

    /**
     * Normalize mapping sources format.
     *
     * @param list<string|Source> $mappingSources
     *
     * @return list<Source>
     */
    protected function normalizeMappingSources(array $mappingSources): array
    {
        return array_values(array_map(
            static function ($mappingSource): array {
                if (\is_array($mappingSource) && \array_key_exists('driver', $mappingSource)) {
                    return ['driver' => $mappingSource['driver']];
                }

                if (!\is_array($mappingSource)) {
                    $mappingSource = [
                        'type' => DriverFactoryInterface::DRIVER_ATTRIBUTE,
                        'path' => $mappingSource,
                    ];
                }

                return $mappingSource;
            },
            $mappingSources,
        ));
    }
}
