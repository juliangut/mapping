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
use Jgut\Mapping\Driver\DriverFactoryInterface;
use Jgut\Mapping\Tests\Stubs\AbstractDriverFactoryStub;
use Jgut\Mapping\Tests\Stubs\AbstractMappingDriverStub;
use Jgut\Mapping\Tests\Stubs\EmptyDriverFactoryStub;
use PHPUnit\Framework\TestCase;

/**
 * Abstract driver factory tests.
 */
class AbstractDriverFactoryTest extends TestCase
{
    /**
     * @var AbstractDriverFactoryStub
     */
    protected $factory;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->factory = new AbstractDriverFactoryStub();
    }

    /**
     * @expectedException \Jgut\Mapping\Exception\DriverException
     * @expectedExceptionMessage Annotation metadata mapping driver is not supported
     */
    public function testAnnotationDriverNotImplemented()
    {
        (new EmptyDriverFactoryStub())->getDriver(['type' => DriverFactoryInterface::DRIVER_ANNOTATION, 'path' => []]);
    }

    /**
     * @expectedException \Jgut\Mapping\Exception\DriverException
     * @expectedExceptionMessage PHP metadata mapping driver is not supported
     */
    public function testPhpDriverNotImplemented()
    {
        (new EmptyDriverFactoryStub())->getDriver(['type' => DriverFactoryInterface::DRIVER_PHP, 'path' => []]);
    }

    /**
     * @expectedException \Jgut\Mapping\Exception\DriverException
     * @expectedExceptionMessage XML metadata mapping driver is not supported
     */
    public function testXmlDriverNotImplemented()
    {
        (new EmptyDriverFactoryStub())->getDriver(['type' => DriverFactoryInterface::DRIVER_XML, 'path' => []]);
    }

    /**
     * @expectedException \Jgut\Mapping\Exception\DriverException
     * @expectedExceptionMessage JSON metadata mapping driver is not supported
     */
    public function testJsonDriverNotImplemented()
    {
        (new EmptyDriverFactoryStub())->getDriver(['type' => DriverFactoryInterface::DRIVER_JSON, 'path' => []]);
    }

    /**
     * @expectedException \Jgut\Mapping\Exception\DriverException
     * @expectedExceptionMessage YAML metadata mapping driver is not supported
     */
    public function testYamlDriverNotImplemented()
    {
        (new EmptyDriverFactoryStub())->getDriver(['type' => DriverFactoryInterface::DRIVER_YAML, 'path' => []]);
    }

    /**
     * @expectedException \Jgut\Mapping\Exception\DriverException
     * @expectedExceptionMessage Mapping must be array with "driver" key or "type" and "path" keys
     */
    public function testInvalidData()
    {
        $this->factory->getDriver([]);
    }

    /**
     * @expectedException \Jgut\Mapping\Exception\DriverException
     * @expectedExceptionMessage "unknown" is not a valid metadata mapping driver
     */
    public function testInvalidType()
    {
        $this->factory->getDriver(['type' => 'unknown', 'path' => []]);
    }

    /**
     * @expectedException \Jgut\Mapping\Exception\DriverException
     * @expectedExceptionMessageRegExp /^Metadata mapping driver should be of the type .+, string given/
     */
    public function testInvalidDriver()
    {
        $this->factory->getDriver(['driver' => 'invalid']);
    }

    public function testDriver()
    {
        $driver = new AbstractMappingDriverStub([]);

        self::assertEquals($driver, $this->factory->getDriver(['driver' => $driver]));
    }

    public function testAnnotationDriver()
    {
        self::assertInstanceOf(
            AbstractAnnotationDriver::class,
            $this->factory->getDriver(['type' => DriverFactoryInterface::DRIVER_ANNOTATION, 'path' => []])
        );
    }

    public function testPhpDriver()
    {
        self::assertInstanceOf(
            AbstractMappingDriver::class,
            $this->factory->getDriver(['type' => DriverFactoryInterface::DRIVER_PHP, 'path' => []])
        );
    }

    public function testJsonDriver()
    {
        self::assertInstanceOf(
            AbstractMappingDriver::class,
            $this->factory->getDriver(['type' => DriverFactoryInterface::DRIVER_JSON, 'path' => []])
        );
    }

    public function testXmlDriver()
    {
        self::assertInstanceOf(
            AbstractMappingDriver::class,
            $this->factory->getDriver(['type' => DriverFactoryInterface::DRIVER_XML, 'path' => []])
        );
    }

    public function testYamlDriver()
    {
        self::assertInstanceOf(
            AbstractMappingDriver::class,
            $this->factory->getDriver(['type' => DriverFactoryInterface::DRIVER_YAML, 'path' => []])
        );
    }
}
