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

namespace Jgut\Mapping\Locator;

/**
 * Mapping files locator.
 */
class FileLocator
{
    /**
     * File paths.
     *
     * @var string[]
     */
    protected $paths = [];

    /**
     * Supported file extensions.
     *
     * @var string[]
     */
    protected $extensions;

    /**
     * AbstractSource constructor.
     *
     * @param string[] $paths
     * @param string[] $extensions
     */
    public function __construct(array $paths, array $extensions)
    {
        $this->paths = $paths;
        $this->extensions = $extensions;
    }

    /**
     * Get file paths.
     *
     * @return string[]
     */
    public function getPaths(): array
    {
        return $this->paths;
    }

    /**
     * Get supported file extensions.
     *
     * @return string[]
     */
    public function getExtensions(): array
    {
        return $this->extensions;
    }

    /**
     * Get mapping files.
     *
     * @throws \RuntimeException
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
                throw new \RuntimeException(sprintf('Path "%s" does not exist', $mappingPath));
            }
        }

        return count($mappingPaths) ? array_merge(...$mappingPaths) : [];
    }

    /**
     * Get mapping files from directory.
     *
     * @param string $mappingDirectory
     *
     * @return array
     */
    protected function getFilesFromDirectory(string $mappingDirectory): array
    {
        $mappingPaths = [];

        $filePattern = sprintf('/^.+\.(%s)$/i', implode('|', $this->extensions));
        $recursiveIterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($mappingDirectory));
        $regexIterator = new \RegexIterator($recursiveIterator, $filePattern, \RecursiveRegexIterator::GET_MATCH);

        foreach ($regexIterator as $mappingFile) {
            $mappingPaths[] = $mappingFile[0];
        }

        sort($mappingPaths);

        return $mappingPaths;
    }
}
