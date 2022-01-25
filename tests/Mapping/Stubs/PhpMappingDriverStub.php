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

use Jgut\Mapping\Driver\DriverInterface;
use Jgut\Mapping\Driver\Traits\PhpMappingTrait;

class PhpMappingDriverStub implements DriverInterface
{
    use PhpMappingTrait {
        getExtensions as originalGetExtensions;
        loadMappingFile as originalLoadMappingFile;
    }

    /**
     * @inheritDoc
     */
    public function getExtensions(): array
    {
        return $this->originalGetExtensions();
    }

    /**
     * @inheritDoc
     */
    public function loadMappingFile(string $mappingFile): array
    {
        return $this->originalLoadMappingFile($mappingFile);
    }

    /**
     * @inheritDoc
     */
    public function getMetadata(): array
    {
        return [new MetadataStub()];
    }
}
