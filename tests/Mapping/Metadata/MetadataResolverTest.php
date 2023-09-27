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

namespace Jgut\Mapping\Tests\Metadata;

use Jgut\Mapping\Driver\DriverFactoryInterface;
use Jgut\Mapping\Metadata\MetadataResolver;
use Jgut\Mapping\Tests\Stubs\AbstractDriverStub;
use Jgut\Mapping\Tests\Stubs\MetadataStub;
use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\CacheInterface;

/**
 * @internal
 */
class MetadataResolverTest extends TestCase
{
    public function testResolver(): void
    {
        $factory = $this->getMockBuilder(DriverFactoryInterface::class)
            ->getMock();
        $factory->expects(static::exactly(2))
            ->method('getDriver')
            ->willReturnOnConsecutiveCalls(
                [
                    [
                        'type' => DriverFactoryInterface::DRIVER_ATTRIBUTE,
                        'path' => __DIR__,
                    ],
                ],
                [
                    ['type' => DriverFactoryInterface::DRIVER_PHP, 'path' => __DIR__],
                ],
            )
            ->willReturn(new AbstractDriverStub([]));

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->getMock();
        $cache->expects(static::once())
            ->method('has')
            ->willReturn(false);
        $cache->expects(static::once())
            ->method('set');

        $mappingSources = [
            __DIR__,
            ['type' => DriverFactoryInterface::DRIVER_PHP, 'path' => __DIR__],
        ];

        $metadata = (new MetadataResolver($factory, $cache))->getMetadata($mappingSources);

        static::assertCount(2, $metadata);
        static::assertInstanceOf(MetadataStub::class, $metadata[0]);
        static::assertInstanceOf(MetadataStub::class, $metadata[1]);
    }

    public function testCachedResolver(): void
    {
        $factory = $this->getMockBuilder(DriverFactoryInterface::class)
            ->getMock();

        $metadataStub = new MetadataStub();

        $cache = $this->getMockBuilder(CacheInterface::class)
            ->getMock();
        $cache->expects(static::once())
            ->method('has')
            ->willReturn(true);
        $cache->expects(static::once())
            ->method('get')
            ->willReturn([$metadataStub]);

        $mappingSources = [
            __DIR__,
            ['type' => DriverFactoryInterface::DRIVER_PHP, 'path' => [__DIR__, __DIR__]],
        ];

        $metadata = (new MetadataResolver($factory, $cache))->getMetadata($mappingSources);

        static::assertCount(1, $metadata);
        static::assertSame($metadataStub, $metadata[0]);
    }
}
