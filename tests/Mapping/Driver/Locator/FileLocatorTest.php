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
use Jgut\Mapping\Tests\Files\Classes\ClassA;
use Jgut\Mapping\Tests\Files\Classes\ClassB;
use Jgut\Mapping\Tests\Stubs\AnnotationStub;
use PHPUnit\Framework\TestCase;

/**
 * Mapping file locator tests.
 */
class FileLocatorTest extends TestCase
{
    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Path "non/existing/path" does not exist
     */
    public function testInvalidPath()
    {
        (new FileLocator(['non/existing/path'], ['php']))->getMappingFiles();
    }

    public function testValidPath()
    {
        $paths = [\dirname(__DIR__, 2) . '/Files/Classes', \dirname(__DIR__, 2) . '/Stubs/AnnotationStub.php'];
        $extensions = ['php'];

        $locator = new FileLocator($paths, $extensions);

        self::assertEquals($paths, $locator->getPaths());
        self::assertEquals($extensions, $locator->getExtensions());

        /** @var \ReflectionClass[] $routing */
        $routing = $locator->getMappingFiles();

        self::assertEquals(
            \dirname(__DIR__, 2) . '/Files/Classes/ClassA.php',
            $routing[0]
        );
        self::assertEquals(
            \dirname(__DIR__, 2) . '/Files/Classes/ClassB.php',
            $routing[1]
        );
        self::assertEquals(
            \dirname(__DIR__, 2) . '/Stubs/AnnotationStub.php',
            $routing[2]
        );
    }
}
