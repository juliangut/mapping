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

namespace Jgut\Mapping\Tests\Driver\Traits;

use Jgut\Mapping\Exception\DriverException;
use Jgut\Mapping\Tests\Stubs\YamlMappingDriverStub;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class YamlMappingTraitTest extends TestCase
{
    protected YamlMappingDriverStub $mapping;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->mapping = new YamlMappingDriverStub();
    }

    public function testExtensions(): void
    {
        static::assertSame(['yml', 'yaml'], $this->mapping->getExtensions());
    }

    public function testLoadError(): void
    {
        $this->expectException(DriverException::class);
        $this->expectExceptionMessageMatches(
            '/^YAML mapping file ".+" parsing error: A colon cannot be used in an unquoted .+\.$/',
        );

        $this->mapping->loadMappingFile(__DIR__ . '/../../Files/files/invalid/invalid.yml');
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
            $this->mapping->loadMappingFile(__DIR__ . '/../../Files/files/valid/valid.yml'),
        );
    }
}
