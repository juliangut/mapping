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

use Jgut\Mapping\Tests\Stubs\AbstractMappingDriverStub;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class AbstractMappingDriverTest extends TestCase
{
    public function testMappings(): void
    {
        $driver = new AbstractMappingDriverStub([__DIR__ . '/../Files/files/valid']);

        static::assertSame(
            [
                'parameterOne' => [
                    'subParameterOne' => 1,
                ],
                'parameterTwo' => 'valueTwo',
                0 => 'parameterThree',
                1 => 'parameterFour',
            ],
            $driver->extractMappingData(),
        );
    }
}
