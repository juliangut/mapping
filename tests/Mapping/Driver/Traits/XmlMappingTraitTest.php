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

use Jgut\Mapping\Tests\Stubs\XmlMappingDriverStub;
use PHPUnit\Framework\TestCase;

/**
 * XML file mapping trait tests.
 */
class XmlMappingTraitTest extends TestCase
{
    /**
     * @var \Jgut\Mapping\Driver\Traits\XmlMappingTrait
     */
    protected $mapping;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->mapping = new XmlMappingDriverStub();
    }

    public function testExtensions()
    {
        self::assertEquals(['xml'], $this->mapping->getExtensions());
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessageRegExp /XML mapping file .+ parsing error: ""/
     */
    public function testLoadError()
    {
        $this->mapping->loadMappingFile(dirname(__DIR__, 2) . '/Files/files/invalid/invalid.xml');
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
            $this->mapping->loadMappingFile(dirname(__DIR__, 2) . '/Files/files/valid/valid.xml')
        );
    }
}
