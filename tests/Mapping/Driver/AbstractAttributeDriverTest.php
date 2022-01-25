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

namespace Jgut\Mapping\Tests\Driver;

use Jgut\Mapping\Tests\Files\Classes\Attribute\ClassA;
use Jgut\Mapping\Tests\Files\Classes\Attribute\ClassB;
use Jgut\Mapping\Tests\Stubs\AbstractAttributeDriverStub;
use Jgut\Mapping\Tests\Stubs\AttributeStub;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * @internal
 */
class AbstractAttributeDriverTest extends TestCase
{
    public function testMappings(): void
    {
        $driver = new AbstractAttributeDriverStub([__DIR__ . '/../Files/Classes/Attribute']);

        $classes = $driver->getMappingClasses();

        static::assertInstanceOf(ReflectionClass::class, $classes[0]);
        static::assertSame(ClassA::class, $classes[0]->getName());

        static::assertInstanceOf(ReflectionClass::class, $classes[1]);
        static::assertSame(ClassB::class, $classes[1]->getName());
    }

    public function testAttributes(): void
    {
        if (version_compare(\PHP_VERSION, '8.0.0') < 0) {
            static::markTestSkipped('No attributes in PHP < 8.0.');
        }

        $driver = new AbstractAttributeDriverStub([__DIR__ . '/../Files/Classes/Attribute']);

        $attributes = $driver->getAttributes();

        static::assertCount(2, $attributes);

        static::assertInstanceOf(AttributeStub::class, $attributes[0]);
        static::assertSame('myClassA', $attributes[0]->getName());

        static::assertInstanceOf(AttributeStub::class, $attributes[1]);
        static::assertSame('myClassB', $attributes[1]->getName());
    }
}
