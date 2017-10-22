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
 * Abstract annotation stub.
 */
class AnnotationStub extends AbstractAnnotation
{
    /**
     * @var string
     */
    protected $known;

    /**
     * @return string
     */
    public function getKnown(): string
    {
        return $this->known;
    }

    /**
     * @param string $known
     */
    public function setKnown(string $known)
    {
        $this->known = $known;
    }
}
