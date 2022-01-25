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

namespace Jgut\Mapping\Tests\Driver;

use Jgut\Mapping\Driver\Locator\FileLocator;
use Jgut\Mapping\Tests\Stubs\AbstractDriverStub;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class AbstractDriverTest extends TestCase
{
    public function testLocator(): void
    {
        static::assertInstanceOf(FileLocator::class, (new AbstractDriverStub([]))->getLocator());
    }
}
