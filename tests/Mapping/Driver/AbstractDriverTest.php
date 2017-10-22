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

use Jgut\Mapping\Locator\FileLocator;
use Jgut\Mapping\Tests\Stubs\AbstractDriverStub;
use PHPUnit\Framework\TestCase;

/**
 * Abstract mapping driver tests.
 */
class AbstractDriverTest extends TestCase
{
    public function testLocator()
    {
        self::assertInstanceOf(FileLocator::class, (new AbstractDriverStub([]))->getLocator());
    }
}
