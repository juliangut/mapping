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
use Jgut\Mapping\Tests\Stubs\JsonMappingDriverStub;
use PHPUnit\Framework\TestCase;

/**
 * JSON file mapping trait tests.
 */
class JsonMappingTraitTest extends TestCase
{
    /**
     * @var \Jgut\Mapping\Driver\Traits\JsonMappingTrait
     */
    protected $mapping;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->mapping = new JsonMappingDriverStub();
    }

    public function testExtensions(): void
    {
        self::assertEquals(['json'], $this->mapping->getExtensions());
    }

    public function testLoadError(): void
    {
        $this->expectException(DriverException::class);
        $this->expectExceptionMessageRegExp('/JSON mapping file .+ parsing error: Syntax error/');

        $this->mapping->loadMappingFile(\dirname(__DIR__, 2) . '/Files/files/invalid/invalid.json');
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
            $this->mapping->loadMappingFile(\dirname(__DIR__, 2) . '/Files/files/valid/valid.json')
        );
    }
}
