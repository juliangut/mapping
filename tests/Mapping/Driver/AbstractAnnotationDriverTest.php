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

use Doctrine\Common\Annotations\AnnotationReader;
use Jgut\Mapping\Tests\Files\Classes\Annotation\ClassA;
use Jgut\Mapping\Tests\Files\Classes\Annotation\ClassB;
use Jgut\Mapping\Tests\Stubs\AbstractAnnotationDriverStub;
use Jgut\Mapping\Tests\Stubs\AnnotationStub;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * @internal
 */
class AbstractAnnotationDriverTest extends TestCase
{
    public function testMappings(): void
    {
        $annotationReader = $this->getMockBuilder(AnnotationReader::class)
            ->disableOriginalConstructor()
            ->getMock();

        $driver = new AbstractAnnotationDriverStub(
            [__DIR__ . '/../Files/Classes/Annotation'],
            $annotationReader,
        );

        $classes = $driver->getMappingClasses();

        static::assertCount(2, $classes);

        static::assertInstanceOf(ReflectionClass::class, $classes[0]);
        static::assertSame(ClassA::class, $classes[0]->getName());

        static::assertInstanceOf(ReflectionClass::class, $classes[1]);
        static::assertSame(ClassB::class, $classes[1]->getName());
    }

    public function testAnnotations(): void
    {
        $annotationReader = new AnnotationReader();

        $driver = new AbstractAnnotationDriverStub(
            [__DIR__ . '/../Files/Classes/Annotation'],
            $annotationReader,
        );

        $annotations = $driver->getAnnotations();

        static::assertCount(2, $annotations);

        static::assertInstanceOf(AnnotationStub::class, $annotations[0]);
        static::assertSame('myClassA', $annotations[0]->getName());

        static::assertInstanceOf(AnnotationStub::class, $annotations[1]);
        static::assertSame('myClassB', $annotations[1]->getName());
    }
}
