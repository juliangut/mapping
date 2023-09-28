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

use Jgut\Mapping\Exception\DriverException;

abstract class AbstractDriverFactory implements DriverFactoryInterface
{
    /**
     * @throws DriverException
     */
    public function getDriver(array $mappingSource): DriverInterface
    {
        if (\array_key_exists('driver', $mappingSource)) {
            $driver = $mappingSource['driver'];

            if (!$driver instanceof DriverInterface) {
                throw new DriverException(sprintf(
                    'Metadata mapping driver should be of the type "%s", "%s" given.',
                    DriverInterface::class,
                    $driver::class,
                ));
            }

            return $driver;
        }

        if (\array_key_exists('type', $mappingSource) && \array_key_exists('path', $mappingSource)) {
            return $this->getDriverImplementation($mappingSource['type'], array_values((array) $mappingSource['path']));
        }

        throw new DriverException(
            'Mapping must be array with "driver" key or "type" and "path" keys.',
        );
    }

    /**
     * @param list<string> $paths
     *
     * @throws DriverException
     */
    protected function getDriverImplementation(string $type, array $paths): DriverInterface
    {
        return match ($type) {
            DriverFactoryInterface::DRIVER_PHP => $this->getPhpDriver($paths),
            DriverFactoryInterface::DRIVER_XML => $this->getXmlDriver($paths),
            DriverFactoryInterface::DRIVER_JSON => $this->getJsonDriver($paths),
            DriverFactoryInterface::DRIVER_YAML => $this->getYamlDriver($paths),
            DriverFactoryInterface::DRIVER_ATTRIBUTE => $this->getAttributeDriver($paths),
            DriverFactoryInterface::DRIVER_ANNOTATION => $this->getAnnotationDriver($paths),
            default => throw new DriverException(sprintf('"%s" is not a valid metadata mapping driver.', $type)),
        };
    }

    /**
     * @param list<string> $paths
     *
     * @throws DriverException
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function getPhpDriver(array $paths): DriverInterface
    {
        throw new DriverException('PHP metadata mapping driver is not supported.');
    }

    /**
     * @param list<string> $paths
     *
     * @throws DriverException
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function getXmlDriver(array $paths): DriverInterface
    {
        throw new DriverException('XML metadata mapping driver is not supported.');
    }

    /**
     * @param list<string> $paths
     *
     * @throws DriverException
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function getJsonDriver(array $paths): DriverInterface
    {
        throw new DriverException('JSON metadata mapping driver is not supported.');
    }

    /**
     * @param list<string> $paths
     *
     * @throws DriverException
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function getYamlDriver(array $paths): DriverInterface
    {
        throw new DriverException('YAML metadata mapping driver is not supported.');
    }

    /**
     * @param list<string> $paths
     *
     * @throws DriverException
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function getAttributeDriver(array $paths): DriverInterface
    {
        throw new DriverException('PHP class attribute metadata mapping driver is not supported.');
    }

    /**
     * @param list<string> $paths
     *
     * @throws DriverException
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function getAnnotationDriver(array $paths): DriverInterface
    {
        throw new DriverException('PHP class annotation metadata mapping driver is not supported.');
    }
}
