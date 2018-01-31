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
     * MetadataResolver constructor.
     *
     * @param DriverFactoryInterface $driverFactory
     */
    public function __construct(DriverFactoryInterface $driverFactory)
    {
        $this->driverFactory = $driverFactory;
    }

    /**
     * Get metadata.
     *
     * @param array $mappingSources
     *
     * @return MetadataInterface[]
     */
    public function getMetadata(array $mappingSources): array
    {
        $metadata = [];
        foreach ($mappingSources as $mappingSource) {
            if (!is_array($mappingSource)) {
                $mappingSource = [
                    'type' => DriverFactoryInterface::DRIVER_ANNOTATION,
                    'path' => $mappingSource,
                ];
            }

            $metadata[] = $this->driverFactory->getDriver($mappingSource)->getMetadata();
        }

        return count($metadata) ? array_merge(...$metadata) : [];
    }
}
