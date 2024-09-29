<?php

/*
 * (c) 2017-2024 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/mapping
 */

declare(strict_types=1);

namespace Jgut\Mapping\Driver\Locator;

use Jgut\Mapping\Exception\DriverException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;

class FileLocator
{
    public function __construct(
        /**
         * @var list<string>
         */
        protected array $paths,
        /**
         * @var list<string>
         */
        protected array $extensions,
    ) {}

    /**
     * @return list<string>
     */
    public function getPaths(): array
    {
        return $this->paths;
    }

    /**
     * Get supported file extensions.
     *
     * @return list<string>
     */
    public function getExtensions(): array
    {
        return $this->extensions;
    }

    /**
     * @throws DriverException
     *
     * @return list<string>
     */
    public function getMappingFiles(): array
    {
        $mappingPaths = [];

        foreach ($this->paths as $mappingPath) {
            if (is_dir($mappingPath)) {
                $mappingPaths[] = $this->getFilesFromDirectory($mappingPath);
            } elseif (is_file($mappingPath)) {
                $mappingPaths[] = [$mappingPath];
            } else {
                throw new DriverException(\sprintf('Path "%s" does not exist.', $mappingPath));
            }
        }

        return \count($mappingPaths) > 0 ? array_merge(...$mappingPaths) : [];
    }

    /**
     * @return list<string>
     */
    protected function getFilesFromDirectory(string $mappingDirectory): array
    {
        $mappingPaths = [];

        $filePattern = \sprintf('/^.+\.(%s)$/i', implode('|', $this->extensions));
        $recursiveIterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($mappingDirectory));
        $regexIterator = new RegexIterator($recursiveIterator, $filePattern, RecursiveRegexIterator::GET_MATCH);

        /** @var list<string> $mappingFile */
        foreach ($regexIterator as $mappingFile) {
            $mappingPaths[] = $mappingFile[0];
        }

        sort($mappingPaths);

        return $mappingPaths;
    }
}
