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

/**
 * Metadata resolver tests.
 */
class MetadataResolverTest extends TestCase
{
    public function testLocator()
    {
        $factory = $this->getMockBuilder(DriverFactoryInterface::class)
            ->getMock();

        $factory->expects($this->exactly(2))
            ->method('getDriver')
            ->will($this->returnValue(new AbstractDriverStub([])));
        /* @var DriverFactoryInterface $factory */

        $mappingSources = [
            __DIR__,
            ['type' => DriverFactoryInterface::DRIVER_PHP, 'path' => __DIR__],
        ];

        $metadata = (new MetadataResolver($factory))->getMetadata($mappingSources);

        self::assertCount(2, $metadata);
        self::assertInstanceOf(MetadataStub::class, $metadata[0]);
        self::assertInstanceOf(MetadataStub::class, $metadata[1]);
    }
}
