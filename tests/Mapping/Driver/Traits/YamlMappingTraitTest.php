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
 * YAML file mapping trait tests.
 */
class YamlMappingTraitTest extends TestCase
{
    /**
     * @var \Jgut\Mapping\Driver\Traits\YamlMappingTrait
     */
    protected $mapping;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->mapping = new YamlMappingDriverStub();
    }

    public function testExtensions(): void
    {
        self::assertEquals(['yml', 'yaml'], $this->mapping->getExtensions());
    }

    public function testLoadError(): void
    {
        $this->expectException(DriverException::class);
        $this->expectExceptionMessageRegExp(
            '/YAML mapping file .+ parsing error: A colon cannot be used in an unquoted .+/'
        );

        $this->mapping->loadMappingFile(\dirname(__DIR__, 2) . '/Files/files/invalid/invalid.yml');
    }

    public function testLoad(): void
    {
        self::assertEquals(
            [
                'parameterOne' => [
                    'subParameterOne' => 'valueOne',
                ],
                'parameterTwo' => 'valueTwo',
            ],
            $this->mapping->loadMappingFile(\dirname(__DIR__, 2) . '/Files/files/valid/valid.yml')
        );
    }
}
