<?php

/*
 * (c) 2017-2024 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/mapping
 */

declare(strict_types=1);

namespace Jgut\Mapping\Tests\Stubs;

use Jgut\Mapping\Driver\AbstractDriver;
use Jgut\Mapping\Driver\Locator\FileLocator;

/**
 * @internal
 */
class AbstractDriverStub extends AbstractDriver
{
    public function getLocator(): FileLocator
    {
        return $this->locator;
    }

    protected function getExtensions(): array
    {
        return [];
    }

    public function getMetadata(): array
    {
        return [new MetadataStub()];
    }
}
