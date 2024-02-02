<?php

/*
 * (c) 2017-2024 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/mapping
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
