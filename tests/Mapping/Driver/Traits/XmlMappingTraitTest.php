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
    protected function setUp(): void
    {
        $this->mapping = new XmlMappingDriverStub();
    }

    public function testExtensions(): void
    {
        self::assertEquals(['xml'], $this->mapping->getExtensions());
    }

    public function testLoadError(): void
    {
        $this->expectException(DriverException::class);
        $this->expectExceptionMessageRegExp('/XML mapping file .+ parsing error: ""/');

        $this->mapping->loadMappingFile(\dirname(__DIR__, 2) . '/Files/files/invalid/invalid.xml');
    }

    public function testLoad(): void
    {
        self::assertEquals(
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
            $this->mapping->loadMappingFile(\dirname(__DIR__, 2) . '/Files/files/valid/valid.xml')
        );
    }
}
