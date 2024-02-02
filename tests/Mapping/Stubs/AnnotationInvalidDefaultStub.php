<?php

/*
 * (c) 2017-2024 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/mapping
 */

declare(strict_types=1);

namespace Jgut\Mapping\Tests\Stubs;

use Jgut\Mapping\Annotation\AbstractAnnotation;

/**
 * @Annotation
 *
 * @Target("CLASS")
 */
class AnnotationInvalidDefaultStub extends AbstractAnnotation
{
    protected function getDefaultProperty(): ?string
    {
        return 'name';
    }
}
