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
use Jgut\Mapping\Exception\DriverException;
use Jgut\Mapping\Tests\Stubs\AbstractDriverFactoryStub;
use Jgut\Mapping\Tests\Stubs\AbstractMappingDriverStub;
use Jgut\Mapping\Tests\Stubs\EmptyDriverFactoryStub;
use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PMD.TooManyPublicMethods)
 *
 * @internal
 */
class AbstractDriverFactoryTest extends TestCase
{
    protected AbstractDriverFactoryStub $factory;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->factory = new AbstractDriverFactoryStub();
    }

    public function testAnnotationDriverNotImplemented(): void
    {
        $this->expectException(DriverException::class);
        $this->expectExceptionMessage('PHP class annotation metadata mapping driver is not supported.');

        (new EmptyDriverFactoryStub())->getDriver(['type' => DriverFactoryInterface::DRIVER_ANNOTATION, 'path' => []]);
    }

    public function testPhpDriverNotImplemented(): void
    {
        $this->expectException(DriverException::class);
        $this->expectExceptionMessage('PHP metadata mapping driver is not supported.');

        (new EmptyDriverFactoryStub())->getDriver(['type' => DriverFactoryInterface::DRIVER_PHP, 'path' => []]);
    }

    public function testXmlDriverNotImplemented(): void
    {
        $this->expectException(DriverException::class);
        $this->expectExceptionMessage('XML metadata mapping driver is not supported.');

        (new EmptyDriverFactoryStub())->getDriver(['type' => DriverFactoryInterface::DRIVER_XML, 'path' => []]);
    }

    public function testJsonDriverNotImplemented(): void
    {
        $this->expectException(DriverException::class);
        $this->expectExceptionMessage('JSON metadata mapping driver is not supported.');

        (new EmptyDriverFactoryStub())->getDriver(['type' => DriverFactoryInterface::DRIVER_JSON, 'path' => []]);
    }

    public function testYamlDriverNotImplemented(): void
    {
        $this->expectException(DriverException::class);
        $this->expectExceptionMessage('YAML metadata mapping driver is not supported.');

        (new EmptyDriverFactoryStub())->getDriver(['type' => DriverFactoryInterface::DRIVER_YAML, 'path' => []]);
    }

    public function testInvalidData(): void
    {
        $this->expectException(DriverException::class);
        $this->expectExceptionMessage('Mapping must be array with "driver" key or "type" and "path" keys.');

        $this->factory->getDriver([]);
    }

    public function testInvalidType(): void
    {
        $this->expectException(DriverException::class);
        $this->expectExceptionMessage('"unknown" is not a valid metadata mapping driver.');

        $this->factory->getDriver(['type' => 'unknown', 'path' => []]);
    }

    public function testInvalidDriver(): void
    {
        $this->expectException(DriverException::class);
        $this->expectExceptionMessageMatches(
            '/^Metadata mapping driver should be of the type ".+", "string" given\.$/',
        );

        $this->factory->getDriver(['driver' => 'invalid']);
    }

    public function testDriver(): void
    {
        $driver = new AbstractMappingDriverStub([]);

        static::assertEquals($driver, $this->factory->getDriver(['driver' => $driver]));
    }

    public function testAnnotationDriver(): void
    {
        static::assertInstanceOf(
            AbstractAnnotationDriver::class,
            $this->factory->getDriver(['type' => DriverFactoryInterface::DRIVER_ANNOTATION, 'path' => []]),
        );
    }

    public function testPhpDriver(): void
    {
        static::assertInstanceOf(
            AbstractMappingDriver::class,
            $this->factory->getDriver(['type' => DriverFactoryInterface::DRIVER_PHP, 'path' => []]),
        );
    }

    public function testJsonDriver(): void
    {
        static::assertInstanceOf(
            AbstractMappingDriver::class,
            $this->factory->getDriver(['type' => DriverFactoryInterface::DRIVER_JSON, 'path' => []]),
        );
    }

    public function testXmlDriver(): void
    {
        static::assertInstanceOf(
            AbstractMappingDriver::class,
            $this->factory->getDriver(['type' => DriverFactoryInterface::DRIVER_XML, 'path' => []]),
        );
    }

    public function testYamlDriver(): void
    {
        static::assertInstanceOf(
            AbstractMappingDriver::class,
            $this->factory->getDriver(['type' => DriverFactoryInterface::DRIVER_YAML, 'path' => []]),
        );
    }
}
