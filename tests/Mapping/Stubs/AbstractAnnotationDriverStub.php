<?php

/*
 * (c) 2017-2024 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/mapping
 */

declare(strict_types=1);

namespace Jgut\Mapping\Tests\Stubs;

use Jgut\Mapping\Driver\AbstractAnnotationDriver;
use ReflectionClass;

/**
 * @internal
 */
class AbstractAnnotationDriverStub extends AbstractAnnotationDriver
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
     * @return list<mixed>
     */
    public function getAnnotations(): array
    {
        $annotations = [];

        foreach ($this->getMappingClasses() as $mappingClass) {
            $annotations[] = $this->annotationReader->getClassAnnotation($mappingClass, AnnotationStub::class);
        }

        return $annotations;
    }
}
