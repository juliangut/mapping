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
use Jgut\Mapping\Metadata\MetadataInterface;

class AbstractClassDriverStub extends AbstractClassDriver
{
    /**
     * Get mapped metadata.
     *
     * @return array<MetadataInterface>
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
