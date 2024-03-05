<?php

/*
 * (c) 2017-2024 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/mapping
 */

declare(strict_types=1);

namespace Jgut\Mapping\Tests\Stubs;

use Jgut\Mapping\Driver\AbstractClassDriver;
use ReflectionClass;

/**
 * @internal
 */
class AbstractAttributeDriverStub extends AbstractClassDriver
{
    /**
     * @return list<ReflectionClass<object>>
     */
    public function extractMappingClasses(): array
    {
        return $this->getMappingClasses();
    }

    public function getMetadata(): array
    {
        return [];
    }

    /**
     * @return array<mixed>>
     */
    public function getAttributes(): array
    {
        $attributes = [];

        foreach ($this->getMappingClasses() as $mappingClass) {
            $attributes[] = $mappingClass->getAttributes(AttributeStub::class)[0]->newInstance();
        }

        return $attributes;
    }
}
