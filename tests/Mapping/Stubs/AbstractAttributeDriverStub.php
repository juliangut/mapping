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

use Jgut\Mapping\Driver\AbstractClassDriver;
use ReflectionClass;

class AbstractAttributeDriverStub extends AbstractClassDriver
{
    /**
     * @return array<ReflectionClass<object>>
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
