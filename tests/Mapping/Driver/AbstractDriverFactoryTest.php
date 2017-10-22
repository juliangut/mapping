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

use Jgut\Mapping\Driver\AbstractAnnotationDriver;
use Jgut\Mapping\Driver\AbstractMappingDriver;
use Jgut\Mapping\Driver\DriverInterface;
use Jgut\Mapping\Tests\Stubs\AbstractDriverFactoryStub;
use Jgut\Mapping\Tests\Stubs\AbstractMappingDriverStub;
use PHPUnit\Framework\TestCase;

/**
 * Abstract driver factory tests.
 */
class AbstractDriverFactoryTest extends TestCase
{
    /**
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage Mapping must be array with "driver" key or "type" and "path" keys
     */
    public function testInvalidData()
    {
        AbstractDriverFactoryStub::getDriver([]);
    }

    /**
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage "unknown" is not a valid metadata mapping type
     */
    public function testInvalidType()
    {
        AbstractDriverFactoryStub::getDriver(['type' => 'unknown', 'path' => []]);
    }

    /**
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage Mapping driver should be of the type Jgut\Mapping\Driver\DriverInterface, string given
     */
    public function testInvalidDriver()
    {
        AbstractDriverFactoryStub::getDriver(['driver' => 'invalid']);
    }

    public function testDriver()
    {
        $driver = new AbstractMappingDriverStub([]);

        self::assertEquals($driver, AbstractDriverFactoryStub::getDriver(['driver' => $driver]));
    }

    public function testAnnotationDriver()
    {
        self::assertInstanceOf(
            AbstractAnnotationDriver::class,
            AbstractDriverFactoryStub::getDriver(['type' => DriverInterface::DRIVER_ANNOTATION, 'path' => []])
        );
    }

    public function testPhpDriver()
    {
        self::assertInstanceOf(
            AbstractMappingDriver::class,
            AbstractDriverFactoryStub::getDriver(['type' => DriverInterface::DRIVER_PHP, 'path' => []])
        );
    }

    public function testJsonDriver()
    {
        self::assertInstanceOf(
            AbstractMappingDriver::class,
            AbstractDriverFactoryStub::getDriver(['type' => DriverInterface::DRIVER_JSON, 'path' => []])
        );
    }

    public function testXmlDriver()
    {
        self::assertInstanceOf(
            AbstractMappingDriver::class,
            AbstractDriverFactoryStub::getDriver(['type' => DriverInterface::DRIVER_XML, 'path' => []])
        );
    }

    public function testYamlDriver()
    {
        self::assertInstanceOf(
            AbstractMappingDriver::class,
            AbstractDriverFactoryStub::getDriver(['type' => DriverInterface::DRIVER_YAML, 'path' => []])
        );
    }
}
