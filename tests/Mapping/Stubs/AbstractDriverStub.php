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

namespace Jgut\Mapping\Tests\Stubs;

use Jgut\Mapping\Driver\AbstractDriver;
use Jgut\Mapping\Driver\Locator\FileLocator;

class AbstractDriverStub extends AbstractDriver
{
    public function getLocator(): FileLocator
    {
        return $this->locator;
    }

    /**
     * @inheritDoc
     */
    protected function getExtensions(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getMetadata(): array
    {
        return [new MetadataStub()];
    }
}
