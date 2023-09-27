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

use Jgut\Mapping\Driver\Locator\FileLocator;

abstract class AbstractDriver implements DriverInterface
{
    protected FileLocator $locator;

    /**
     * @param list<string> $paths
     */
    public function __construct(array $paths)
    {
        $this->locator = new FileLocator($paths, $this->getExtensions());
    }

    /**
     * Get supported mapping file extensions.
     *
     * @return list<string>
     */
    abstract protected function getExtensions(): array;
}
