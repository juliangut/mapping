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

use Jgut\Mapping\Tests\Stubs\PhpMappingDriverStub;
use PHPUnit\Framework\TestCase;

/**
 * PHP file mapping trait tests.
 */
class PhpMappingTraitTest extends TestCase
{
    /**
     * @var \Jgut\Mapping\Driver\Traits\PhpMappingTrait
     */
    protected $mapping;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->mapping = new PhpMappingDriverStub();
    }

    public function testExtensions(): void
    {
        self::assertEquals(['php'], $this->mapping->getExtensions());
    }

    public function testLoad(): void
    {
        self::assertEquals(
            [
                'parameterOne' => [
                    'subParameterOne' => 'valueOne',
                ],
                'parameterTwo' => 'valueTwo',
                0 => 'parameterThree',
            ],
            $this->mapping->loadMappingFile(\dirname(__DIR__, 2) . '/Files/files/valid/validA.php')
        );
    }
}
