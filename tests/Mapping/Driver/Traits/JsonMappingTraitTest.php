<?php

/*
 * (c) 2017-2024 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/mapping
 */

declare(strict_types=1);

namespace Jgut\Mapping\Tests\Driver\Traits;

use Jgut\Mapping\Exception\DriverException;
use Jgut\Mapping\Tests\Stubs\JsonMappingDriverStub;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class JsonMappingTraitTest extends TestCase
{
    protected JsonMappingDriverStub $mapping;

    protected function setUp(): void
    {
        $this->mapping = new JsonMappingDriverStub();
    }

    public function testExtensions(): void
    {
        static::assertSame(['json'], $this->mapping->getExtensions());
    }

    public function testLoadError(): void
    {
        $this->expectException(DriverException::class);
        $this->expectExceptionMessageMatches('/^JSON mapping file ".+" parsing error: Syntax error\.$/');

        $this->mapping->loadMappingFile(__DIR__ . '/../../Files/files/invalid/invalid.json');
    }

    public function testLoad(): void
    {
        static::assertSame(
            [
                'parameterOne' => [
                    'subParameterOne' => 'valueOne',
                ],
                'parameterTwo' => 'valueTwo',
            ],
            $this->mapping->loadMappingFile(__DIR__ . '/../../Files/files/valid/valid.json'),
        );
    }
}
