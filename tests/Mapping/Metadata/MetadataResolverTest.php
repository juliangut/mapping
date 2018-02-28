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

use Jgut\Mapping\Driver\DriverFactoryInterface;
use Jgut\Mapping\Metadata\MetadataResolver;
use Jgut\Mapping\Tests\Stubs\AbstractDriverStub;
use Jgut\Mapping\Tests\Stubs\MetadataStub;
use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\CacheInterface;

/**
 * Metadata resolver tests.
 */
class MetadataResolverTest extends TestCase
{
    public function testResolver()
    {
        $factory = $this->getMockBuilder(DriverFactoryInterface::class)
            ->getMock();
        $factory->expects($this->exactly(2))
            ->method('getDriver')
            ->will($this->returnValue(new AbstractDriverStub([])));
        /* @var DriverFactoryInterface $factory */

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->getMock();
        $cache->expects($this->once())
            ->method('has')
            ->will($this->returnValue(false));
        $cache->expects($this->once())
            ->method('set');
        /* @var CacheInterface $cache */

        $mappingSources = [
            __DIR__,
            ['type' => DriverFactoryInterface::DRIVER_PHP, 'path' => __DIR__],
        ];

        $metadata = (new MetadataResolver($factory, $cache))->getMetadata($mappingSources);

        self::assertCount(2, $metadata);
        self::assertInstanceOf(MetadataStub::class, $metadata[0]);
        self::assertInstanceOf(MetadataStub::class, $metadata[1]);
    }

    public function testCachedResolver()
    {
        $factory = $this->getMockBuilder(DriverFactoryInterface::class)
            ->getMock();
        /* @var DriverFactoryInterface $factory */

        $metadataStub = new MetadataStub();

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->getMock();
        $cache->expects($this->once())
            ->method('has')
            ->will($this->returnValue(true));
        $cache->expects($this->once())
            ->method('get')
            ->will($this->returnValue([$metadataStub]));
        /* @var CacheInterface $cache */

        $mappingSources = [
            __DIR__,
            ['type' => DriverFactoryInterface::DRIVER_PHP, 'path' => [__DIR__, __DIR__]],
        ];

        $metadata = (new MetadataResolver($factory, $cache))->getMetadata($mappingSources);

        self::assertCount(1, $metadata);
        self::assertEquals($metadataStub, $metadata[0]);
    }
}
