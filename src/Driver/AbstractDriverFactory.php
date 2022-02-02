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
     * @inheritDoc
     *
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
                    \is_object($driver) ? \get_class($driver) : \gettype($driver),
                ));
            }

            return $driver;
        }

        $supportedKeys = ['type', 'path'];
        if (\count(array_intersect($supportedKeys, array_keys($mappingSource))) === \count($supportedKeys)) {
            return $this->getDriverImplementation((string) $mappingSource['type'], (array) $mappingSource['path']);
        }

        throw new DriverException(
            'Mapping must be array with "driver" key or "type" and "path" keys.',
        );
    }

    /**
     * Get mapping driver implementation.
     *
     * @param array<string> $paths
     *
     * @throws DriverException
     */
    protected function getDriverImplementation(string $type, array $paths): DriverInterface
    {
        switch ($type) {
            case DriverFactoryInterface::DRIVER_PHP:
                return $this->getPhpDriver($paths);

            case DriverFactoryInterface::DRIVER_XML:
                return $this->getXmlDriver($paths);

            case DriverFactoryInterface::DRIVER_JSON:
                return $this->getJsonDriver($paths);

            case DriverFactoryInterface::DRIVER_YAML:
                return $this->getYamlDriver($paths);

            case DriverFactoryInterface::DRIVER_ATTRIBUTE:
                return $this->getAttributeDriver($paths);

            case DriverFactoryInterface::DRIVER_ANNOTATION:
                return $this->getAnnotationDriver($paths);
        }

        throw new DriverException(
            sprintf('"%s" is not a valid metadata mapping driver.', $type),
        );
    }

    /**
     * Get native PHP file based mapping driver.
     *
     * @param array<string> $paths
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
     * Get XML file based mapping driver.
     *
     * @param array<string> $paths
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
     * Get JSON file based mapping driver.
     *
     * @param array<string> $paths
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
     * Get YAML file based mapping driver.
     *
     * @param array<string> $paths
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
     * Get PHP class attribute based mapping driver.
     *
     * @param array<string> $paths
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
     * Get annotation based mapping driver.
     *
     * @param array<string> $paths
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
