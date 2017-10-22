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

/**
 * Abstract driver factory stub.
 */
class AbstractDriverFactoryStub extends AbstractDriverFactory
{
    /**
     * {@inheritdoc}
     */
    protected static function getAnnotationDriver(array $paths): DriverInterface
    {
        return new AbstractAnnotationDriverStub($paths, new AnnotationReader());
    }

    /**
     * {@inheritdoc}
     */
    protected static function getPhpDriver(array $paths): DriverInterface
    {
        return new AbstractMappingDriverStub($paths);
    }

    /**
     * {@inheritdoc}
     */
    protected static function getXmlDriver(array $paths): DriverInterface
    {
        return new AbstractMappingDriverStub($paths);
    }

    /**
     * {@inheritdoc}
     */
    protected static function getJsonDriver(array $paths): DriverInterface
    {
        return new AbstractMappingDriverStub($paths);
    }

    /**
     * {@inheritdoc}
     */
    protected static function getYamlDriver(array $paths): DriverInterface
    {
        return new AbstractMappingDriverStub($paths);
    }
}
