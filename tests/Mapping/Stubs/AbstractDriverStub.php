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
use Jgut\Mapping\Locator\FileLocator;

/**
 * Abstract mapping driver stub.
 */
class AbstractDriverStub extends AbstractDriver
{
    public function getLocator(): FileLocator
    {
        return $this->locator;
    }

    /**
     * {@inheritdoc}
     */
    protected function getExtensions(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getMetadata(): array
    {
        return [];
    }
}
