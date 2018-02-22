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
    protected function setUp()
    {
        $this->mapping = new JsonMappingDriverStub();
    }

    public function testExtensions()
    {
        self::assertEquals(['json'], $this->mapping->getExtensions());
    }

    /**
     * @expectedException \Jgut\Mapping\Exception\DriverException
     * @expectedExceptionMessageRegExp /JSON mapping file .+ parsing error: Syntax error/
     */
    public function testLoadError()
    {
        $this->mapping->loadMappingFile(\dirname(__DIR__, 2) . '/Files/files/invalid/invalid.json');
    }

    public function testLoad()
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
