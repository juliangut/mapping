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

use Jgut\Mapping\Driver\AbstractAnnotationDriver;
use ReflectionClass;

class AbstractAnnotationDriverStub extends AbstractAnnotationDriver
{
    /**
     * @return array<ReflectionClass<object>>
     */
    public function extractMappingClasses(): array
    {
        return $this->getMappingClasses();
    }

    /**
     * @inheritDoc
     */
    public function getMetadata(): array
    {
        return [];
    }

    /**
     * @return array<mixed>
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
