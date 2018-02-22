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
 * Driver factory interface.
 */
interface DriverFactoryInterface
{
    const DRIVER_ANNOTATION = 'annotation';

    const DRIVER_PHP = 'php';

    const DRIVER_XML = 'xml';

    const DRIVER_JSON = 'json';

    const DRIVER_YAML = 'yaml';

    /**
     * Get mapping driver.
     *
     * @param array $mappingSource
     *
     * @return DriverInterface
     */
    public function getDriver(array $mappingSource): DriverInterface;
}
