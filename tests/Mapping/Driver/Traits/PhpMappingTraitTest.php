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
 * @internal
 */
class PhpMappingTraitTest extends TestCase
{
    protected PhpMappingDriverStub $mapping;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->mapping = new PhpMappingDriverStub();
    }

    public function testExtensions(): void
    {
        static::assertSame(['php'], $this->mapping->getExtensions());
    }

    public function testLoad(): void
    {
        static::assertSame(
            [
                'parameterOne' => [
                    'subParameterOne' => 'valueOne',
                ],
                'parameterTwo' => 'valueTwo',
                0 => 'parameterThree',
            ],
            $this->mapping->loadMappingFile(__DIR__ . '/../../Files/files/valid/validA.php'),
        );
    }
}
