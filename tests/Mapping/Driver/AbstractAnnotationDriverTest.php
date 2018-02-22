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
use Jgut\Mapping\Tests\Files\Classes\ClassA;
use Jgut\Mapping\Tests\Files\Classes\ClassB;
use Jgut\Mapping\Tests\Stubs\AbstractAnnotationDriverStub;
use PHPUnit\Framework\TestCase;

/**
 * Abstract annotation mapping driver tests.
 */
class AbstractAnnotationDriverTest extends TestCase
{
    public function testMappings()
    {
        $annotationReader = $this->getMockBuilder(AnnotationReader::class)
            ->disableOriginalConstructor()
            ->getMock();
        /* @var AnnotationReader $annotationReader */

        $driver = new AbstractAnnotationDriverStub([\dirname(__DIR__) . '/Files/Classes'], $annotationReader);

        /** @var \ReflectionClass[] $classes */
        $classes = $driver->getMappingClasses();

        self::assertInstanceOf(\ReflectionClass::class, $classes[0]);
        self::assertEquals(ClassA::class, $classes[0]->getName());

        self::assertInstanceOf(\ReflectionClass::class, $classes[1]);
        self::assertEquals(ClassB::class, $classes[1]->getName());
    }
}
