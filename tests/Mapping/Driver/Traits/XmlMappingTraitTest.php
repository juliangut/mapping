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
use Jgut\Mapping\Tests\Stubs\XmlMappingDriverStub;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class XmlMappingTraitTest extends TestCase
{
    protected XmlMappingDriverStub $mapping;

    protected function setUp(): void
    {
        $this->mapping = new XmlMappingDriverStub();
    }

    public function testExtensions(): void
    {
        static::assertSame(['xml'], $this->mapping->getExtensions());
    }

    public function testLoadError(): void
    {
        $this->expectException(DriverException::class);
        $this->expectExceptionMessageMatches('/^XML mapping file ".+" parsing error: \.$/');

        $this->mapping->loadMappingFile(__DIR__ . '/../../Files/files/invalid/invalid.xml');
    }

    public function testLoad(): void
    {
        static::assertSame(
            [
                'parameterOne' => [
                    'trueValue' => true,
                    'falseValue' => false,
                ],
                'parameterTwo' => [
                    'floatValue' => 1.1,
                    'intValue' => 2,
                ],
                'parameterThree' => [
                    'foo' => 'bar',
                    '_value_' => 'valueThree',
                ],
            ],
            $this->mapping->loadMappingFile(__DIR__ . '/../../Files/files/valid/valid.xml'),
        );
    }
}
