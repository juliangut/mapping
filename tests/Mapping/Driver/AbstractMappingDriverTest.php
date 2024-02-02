<?php

/*
 * (c) 2017-2024 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/mapping
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
