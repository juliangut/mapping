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

namespace Jgut\Mapping\Tests\Driver\Locator;

use Jgut\Mapping\Driver\Locator\FileLocator;
use PHPUnit\Framework\TestCase;

/**
 * Mapping file locator tests.
 */
class FileLocatorTest extends TestCase
{
    public function testInvalidPath(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Path "non/existing/path" does not exist.');

        (new FileLocator(['non/existing/path'], ['php']))->getMappingFiles();
    }

    public function testValidPath(): void
    {
        $paths = [\dirname(__DIR__, 2) . '/Files/Classes', \dirname(__DIR__, 2) . '/Stubs/AnnotationStub.php'];
        $extensions = ['php'];

        $locator = new FileLocator($paths, $extensions);

        static::assertSame($paths, $locator->getPaths());
        static::assertSame($extensions, $locator->getExtensions());

        $routing = $locator->getMappingFiles();

        static::assertSame(
            \dirname(__DIR__, 2) . '/Files/Classes/Annotation/ClassA.php',
            $routing[0]
        );
        static::assertSame(
            \dirname(__DIR__, 2) . '/Files/Classes/Annotation/ClassB.php',
            $routing[1]
        );
        static::assertSame(
            \dirname(__DIR__, 2) . '/Files/Classes/Attribute/ClassA.php',
            $routing[2]
        );
        static::assertSame(
            \dirname(__DIR__, 2) . '/Files/Classes/Attribute/ClassB.php',
            $routing[3]
        );
        static::assertSame(
            \dirname(__DIR__, 2) . '/Stubs/AnnotationStub.php',
            $routing[4]
        );
    }
}
