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

use Jgut\Mapping\Driver\AbstractMappingDriver;
use Jgut\Mapping\Driver\Traits\PhpMappingTrait;
use ReflectionClass;

class AbstractMappingDriverStub extends AbstractMappingDriver
{
    use PhpMappingTrait;

    /**
     * @return array<ReflectionClass<object>>
     */
    public function extractMappingData(): array
    {
        return $this->getMappingData();
    }

    public function getMetadata(): array
    {
        return [];
    }
}
