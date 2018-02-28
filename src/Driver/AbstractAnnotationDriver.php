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

namespace Jgut\Mapping\Driver;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\Reader;

/**
 * Abstract annotation mapping driver.
 */
abstract class AbstractAnnotationDriver extends AbstractDriver
{
    /**
     * Annotations reader.
     *
     * @var Reader
     */
    protected $annotationReader;

    /**
     * AnnotationDriver constructor.
     *
     * @param string[] $paths
     * @param Reader   $annotationReader
     */
    public function __construct(array $paths, Reader $annotationReader)
    {
        parent::__construct($paths);

        $this->annotationReader = $annotationReader;
    }

    /**
     * {@inheritdoc}
     */
    protected function getExtensions(): array
    {
        return ['php'];
    }

    /**
     * Get mapping classes.
     *
     * @throws \Jgut\Mapping\Exception\DriverException
     *
     * @return \ReflectionClass[]
     */
    protected function getMappingClasses(): array
    {
        AnnotationRegistry::registerLoader('class_exists');

        $mappingClasses = [];

        foreach ($this->locator->getMappingFiles() as $annotationFile) {
            $mappingClasses[] = $this->loadClassFromFile($annotationFile);
        }

        return \array_map(
            function (string $sourceClass) {
                return new \ReflectionClass($sourceClass);
            },
            \array_filter(\array_unique($mappingClasses))
        );
    }

    /**
     * Load fully qualified class name from file.
     *
     * @param string $annotationFile
     *
     * @return string
     *
     * @SuppressWarnings(PMD.CyclomaticComplexity)
     * @SuppressWarnings(PMD.NPathComplexity)
     */
    protected function loadClassFromFile(string $annotationFile): string
    {
        $tokens = \token_get_all(\file_get_contents($annotationFile));
        $hasClass = false;
        $class = null;
        $hasNamespace = false;
        $namespace = '';

        for ($i = 0, $length = \count($tokens); $i < $length; $i++) {
            $token = $tokens[$i];

            if (!\is_array($token)) {
                continue;
            }

            if ($hasClass && $token[0] === T_STRING) {
                $class = $namespace . '\\' . $token[1];

                break;
            }

            if ($hasNamespace && $token[0] === T_STRING) {
                $namespace = '';

                do {
                    $namespace .= $token[1];

                    $token = $tokens[++$i];
                } while ($i < $length && \is_array($token) && \in_array($token[0], [T_NS_SEPARATOR, T_STRING], true));

                $hasNamespace = false;
            }

            if ($token[0] === T_CLASS) {
                $hasClass = true;
            }
            if ($token[0] === T_NAMESPACE) {
                $hasNamespace = true;
            }
        }

        return $class ?: '';
    }
}
