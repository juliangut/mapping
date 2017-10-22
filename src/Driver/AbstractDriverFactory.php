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
 * Abstract driver factory.
 */
abstract class AbstractDriverFactory
{
    /**
     * Get mapping driver.
     *
     * @param array $mapping
     *
     * @throws \UnexpectedValueException
     *
     * @return DriverInterface
     */
    public static function getDriver(array $mapping): DriverInterface
    {
        if (array_key_exists('driver', $mapping)) {
            $driver = $mapping['driver'];

            if (!$driver instanceof DriverInterface) {
                throw new \UnexpectedValueException(sprintf(
                    'Mapping driver should be of the type %s, %s given',
                    DriverInterface::class,
                    is_object($driver) ? get_class($driver) : gettype($driver)
                ));
            }

            return $driver;
        }

        if (count(array_intersect(['type', 'path'], array_keys($mapping))) === 2) {
            return static::getDriverImplementation($mapping['type'], (array) $mapping['path']);
        }

        throw new \UnexpectedValueException(
            'Mapping must be array with "driver" key or "type" and "path" keys'
        );
    }

    /**
     * Get mapping driver implementation.
     *
     * @param string $type
     * @param array  $paths
     *
     * @throws \UnexpectedValueException
     *
     * @return DriverInterface
     */
    protected static function getDriverImplementation(string $type, array $paths): DriverInterface
    {
        switch ($type) {
            case DriverInterface::DRIVER_ANNOTATION:
                return static::getAnnotationDriver($paths);

            case DriverInterface::DRIVER_PHP:
                return static::getPhpDriver($paths);

            case DriverInterface::DRIVER_XML:
                return static::getXmlDriver($paths);

            case DriverInterface::DRIVER_JSON:
                return static::getJsonDriver($paths);

            case DriverInterface::DRIVER_YAML:
                return static::getYamlDriver($paths);
        }

        throw new \UnexpectedValueException(
            sprintf('"%s" is not a valid metadata mapping type', $type)
        );
    }

    /**
     * Get annotation based mapping driver.
     *
     * @param array $paths
     *
     * @return DriverInterface
     */
    abstract protected static function getAnnotationDriver(array $paths): DriverInterface;

    /**
     * Get native PHP file based mapping driver.
     *
     * @param array $paths
     *
     * @return DriverInterface
     */
    abstract protected static function getPhpDriver(array $paths): DriverInterface;

    /**
     * Get XML file based mapping driver.
     *
     * @param array $paths
     *
     * @return DriverInterface
     */
    abstract protected static function getXmlDriver(array $paths): DriverInterface;

    /**
     * Get JSON file based mapping driver.
     *
     * @param array $paths
     *
     * @return DriverInterface
     */
    abstract protected static function getJsonDriver(array $paths): DriverInterface;

    /**
     * Get YAML file based mapping driver.
     *
     * @param array $paths
     *
     * @return DriverInterface
     */
    abstract protected static function getYamlDriver(array $paths): DriverInterface;
}
