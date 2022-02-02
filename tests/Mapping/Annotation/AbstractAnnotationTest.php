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

namespace Jgut\Mapping\Tests\Annotation;

use Jgut\Mapping\Exception\AnnotationException;
use Jgut\Mapping\Tests\Stubs\AnnotationStub;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class AbstractAnnotationTest extends TestCase
{
    public function testInvalidParameters(): void
    {
        $this->expectException(AnnotationException::class);
        $this->expectExceptionMessage('Annotation parameters must be an iterable.');

        new AnnotationStub('invalid');
    }

    public function testUnknownParameter(): void
    {
        $this->expectException(AnnotationException::class);
        $this->expectExceptionMessage('The following annotation properties are not recognized: unknown.');

        new AnnotationStub(['unknown' => '']);
    }

    public function testParameters(): void
    {
        $annotation = new AnnotationStub(['name' => 'Text']);

        static::assertSame('Text', $annotation->getName());
    }
}
