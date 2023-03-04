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

namespace Jgut\Mapping\Tests\Stubs;

use Doctrine\Common\Annotations\AnnotationReader;
use Jgut\Mapping\Driver\AbstractDriverFactory;
use Jgut\Mapping\Driver\DriverInterface;

class AbstractDriverFactoryStub extends AbstractDriverFactory
{
    protected function getPhpDriver(array $paths): DriverInterface
    {
        return new AbstractMappingDriverStub($paths);
    }

    protected function getXmlDriver(array $paths): DriverInterface
    {
        return new AbstractMappingDriverStub($paths);
    }

    protected function getJsonDriver(array $paths): DriverInterface
    {
        return new AbstractMappingDriverStub($paths);
    }

    protected function getYamlDriver(array $paths): DriverInterface
    {
        return new AbstractMappingDriverStub($paths);
    }

    protected function getAttributeDriver(array $paths): DriverInterface
    {
        return new AbstractAttributeDriverStub($paths);
    }

    protected function getAnnotationDriver(array $paths): DriverInterface
    {
        return new AbstractAnnotationDriverStub($paths, new AnnotationReader());
    }
}
