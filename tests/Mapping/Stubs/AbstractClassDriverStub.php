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
use Jgut\Mapping\Metadata\MetadataInterface;

/**
 * @internal
 */
class AbstractClassDriverStub extends AbstractClassDriver
{
    /**
     * Get mapped metadata.
     *
     * @return list<MetadataInterface>
     */
    public function getMetadata(): array
    {
        return [];
    }

    public function loadClassFromFile(string $mappingFile, bool $uselessVariable = true): ?string
    {
        return parent::loadClassFromFile($mappingFile);
    }
}
