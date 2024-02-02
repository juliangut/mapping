<?php

/*
 * (c) 2017-2024 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/mapping
 */

declare(strict_types=1);

namespace Jgut\Mapping\Tests\Driver\Locator;

use Jgut\Mapping\Driver\Locator\FileLocator;
use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 * @internal
 */
class FileLocatorTest extends TestCase
{
    public function testInvalidPath(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Path "non/existing/path" does not exist.');

        (new FileLocator(['non/existing/path'], ['php']))->getMappingFiles();
    }

    public function testValidPath(): void
    {
        $paths = [
            __DIR__ . '/../../Files/Classes/Valid',
            __DIR__ . '/../../Stubs/AnnotationStub.php',
        ];
        $extensions = ['php'];

        $locator = new FileLocator($paths, $extensions);

        static::assertSame($paths, $locator->getPaths());
        static::assertSame($extensions, $locator->getExtensions());

        $routing = $locator->getMappingFiles();

        static::assertSame(
            __DIR__ . '/../../Files/Classes/Valid/Annotation/ClassA.php',
            $routing[0],
        );
        static::assertSame(
            __DIR__ . '/../../Files/Classes/Valid/Annotation/ClassB.php',
            $routing[1],
        );
        static::assertSame(
            __DIR__ . '/../../Files/Classes/Valid/Attribute/ClassA.php',
            $routing[2],
        );
        static::assertSame(
            __DIR__ . '/../../Files/Classes/Valid/Attribute/ClassB.php',
            $routing[3],
        );
        static::assertSame(
            __DIR__ . '/../../Stubs/AnnotationStub.php',
            $routing[4],
        );
    }
}
