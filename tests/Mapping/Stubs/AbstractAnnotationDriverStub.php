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

/**
 * Abstract annotation mapping driver stub.
 */
class AbstractAnnotationDriverStub extends AbstractAnnotationDriver
{
    /**
     * {@inheritdoc}
     */
    public function getMappingClasses(): array
    {
        return parent::getMappingClasses();
    }

    /**
     * {@inheritdoc}
     */
    public function getMetadata(): array
    {
        return [];
    }
}
