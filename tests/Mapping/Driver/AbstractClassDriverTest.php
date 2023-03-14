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

use Jgut\Mapping\Tests\Files\Classes\Valid\Attribute\ClassA;
use Jgut\Mapping\Tests\Stubs\AbstractClassDriverStub;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class AbstractClassDriverTest extends TestCase
{
    public function testClassLoader(): void
    {
        $driver = new AbstractClassDriverStub([__DIR__ . '/../Files/Classes/Valid/Attribute']);

        $className = $driver->loadClassFromFile(__DIR__ . '/../Files/Classes/Valid/Attribute/ClassA.php');
        $traitName = $driver->loadClassFromFile(__DIR__ . '/../Files/Classes/Invalid/Attribute/Trait.php');
        $interfaceName = $driver->loadClassFromFile(__DIR__ . '/../Files/Classes/Invalid/Attribute/Interface.php');

        static::assertSame(ClassA::class, $className);
        static::assertNull($traitName);
        static::assertNull($interfaceName);
    }
}
