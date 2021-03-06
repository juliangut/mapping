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

/**
 * Abstract PHP class mapping driver.
 */
abstract class AbstractClassDriver extends AbstractDriver
{
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
     * @return array<\ReflectionClass<object>>
     */
    protected function getMappingClasses(): array
    {
        /** @var array<class-string<object>> $mappingClasses */
        $mappingClasses = [];

        foreach ($this->locator->getMappingFiles() as $annotationFile) {
            $mappingClasses[] = $this->loadClassFromFile($annotationFile);
        }

        return \array_map(
            function (string $sourceClass): \ReflectionClass {
                /** @var class-string<object> $sourceClass */
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
        $content = \file_get_contents($annotationFile);
        $tokens = \token_get_all($content !== false ? $content : '');
        $hasClass = false;
        $class = null;
        $hasNamespace = false;
        $namespace = '';

        for ($i = 0, $length = \count($tokens); $i < $length; $i++) {
            $token = $tokens[$i];

            if (!\is_array($token)) {
                continue;
            }

            if ($hasClass && $token[0] === \T_STRING) {
                $class = $namespace . '\\' . $token[1];

                break;
            }

            if ($hasNamespace) {
                if (\version_compare(\PHP_VERSION, '8.0.0') >= 0 && $token[0] === \T_NAME_QUALIFIED) {
                    $namespace .= $token[1];

                    $hasNamespace = false;
                } elseif ($token[0] === \T_STRING) {
                    do {
                        $namespace .= $token[1];

                        $token = $tokens[++$i];
                    } while ($i < $length
                        && \is_array($token)
                        && \in_array($token[0], [\T_NS_SEPARATOR, \T_STRING], true)
                    );

                    $hasNamespace = false;
                }
            }

            if ($token[0] === \T_CLASS) {
                $hasClass = true;
            }
            if ($token[0] === \T_NAMESPACE) {
                $hasNamespace = true;
            }
        }

        return $class ?? '';
    }
}
