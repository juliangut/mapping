<?php

/*
 * (c) 2017-2024 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/mapping
 */

declare(strict_types=1);

namespace Jgut\Mapping\Tests\Driver;

use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\Common\Annotations\AnnotationReader;
use Jgut\Mapping\Tests\Files\Classes\Valid\Annotation\ClassA;
use Jgut\Mapping\Tests\Files\Classes\Valid\Annotation\ClassB;
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
            [__DIR__ . '/../Files/Classes/Valid/Annotation'],
            $annotationReader,
        );

        $classes = $driver->extractMappingClasses();

        static::assertCount(2, $classes);

        static::assertInstanceOf(ReflectionClass::class, $classes[0]);
        static::assertSame(ClassA::class, $classes[0]->getName());

        static::assertInstanceOf(ReflectionClass::class, $classes[1]);
        static::assertSame(ClassB::class, $classes[1]->getName());
    }

    public function testInvalidAnnotationProperty(): void
    {
        $this->expectException(AnnotationException::class);
        $this->expectExceptionMessageMatches('/Default annotation property "name" does not exist\./');

        $driver = new AbstractAnnotationDriverStub(
            [__DIR__ . '/../Files/Classes/Invalid/Annotation/ClassInvalidProperty.php'],
            new AnnotationReader(),
        );

        $driver->getAnnotations();
    }

    public function testInvalidAnnotationMethod(): void
    {
        $this->expectException(AnnotationException::class);
        $this->expectExceptionMessageMatches('/Annotation property setter "setPath" does not exist\./');

        $driver = new AbstractAnnotationDriverStub(
            [__DIR__ . '/../Files/Classes/Invalid/Annotation/ClassInvalidMethod.php'],
            new AnnotationReader(),
        );

        $driver->getAnnotations();
    }

    public function testAnnotations(): void
    {
        $driver = new AbstractAnnotationDriverStub(
            [__DIR__ . '/../Files/Classes/Valid/Annotation'],
            new AnnotationReader(),
        );

        $annotations = $driver->getAnnotations();

        static::assertCount(2, $annotations);

        static::assertInstanceOf(AnnotationStub::class, $annotations[0]);
        static::assertSame('myClassA', $annotations[0]->getName());

        static::assertInstanceOf(AnnotationStub::class, $annotations[1]);
        static::assertSame('myClassB', $annotations[1]->getName());
    }
}
