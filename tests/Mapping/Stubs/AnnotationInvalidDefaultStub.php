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

use Jgut\Mapping\Annotation\AbstractAnnotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
class AnnotationInvalidDefaultStub extends AbstractAnnotation
{
    /**
     * @inheritDoc
     */
    protected function getDefaultProperty(): ?string
    {
        return 'name';
    }
}
