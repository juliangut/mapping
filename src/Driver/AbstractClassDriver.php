<?php

/*
 * (c) 2017-2024 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/mapping
 */

declare(strict_types=1);

namespace Jgut\Mapping\Driver;

use Jgut\Mapping\Exception\DriverException;
use ReflectionClass;

abstract class AbstractClassDriver extends AbstractDriver
{
    protected function getExtensions(): array
    {
        return ['php'];
    }

    /**
     * @throws DriverException
     *
     * @return list<ReflectionClass<object>>
     */
    protected function getMappingClasses(): array
    {
        $mappingClasses = [];
        foreach ($this->locator->getMappingFiles() as $mappingFile) {
            $mappingClasses[] = $this->loadClassFromFile($mappingFile);
        }

        return array_values(array_map(
            static fn(string $sourceClass): ReflectionClass => new ReflectionClass($sourceClass),
            array_filter(array_unique($mappingClasses), static fn(?string $sourceClass): bool => $sourceClass !== null),
        ));
    }

    /**
     * Load fully qualified class name from file.
     *
     * @return class-string<object>|null
     */
    protected function loadClassFromFile(string $mappingFile): ?string
    {
        $content = file_get_contents($mappingFile);
        $tokens = token_get_all($content !== false ? $content : '');

        $next = $this->findNextToken($tokens, [\T_NAMESPACE]);
        if ($next === null) {
            return null;
        }

        $validTokenTypes = $this->getValidTokenTypes();
        $class = '';

        while (
            \array_key_exists($next + 1, $tokens)
            && \is_array($tokens[$next + 1])
            && \in_array($tokens[$next + 1][0], $validTokenTypes, true)
        ) {
            $class .= trim($tokens[$next + 1][1]);

            ++$next;
        }

        // Exclude traits and interfaces
        if ($this->findNextToken($tokens, [\T_TRAIT, \T_INTERFACE], $next + 1) !== null) {
            return null;
        }

        $next = $this->findNextToken($tokens, [\T_CLASS], $next + 1, \T_DOUBLE_COLON);
        if ($next === null) {
            return null;
        }

        $next = $this->findNextToken($tokens, [\T_STRING], $next + 1);
        if ($next === null) {
            return null;
        }

        $class .= '\\' . $tokens[$next][1];

        /** @var class-string<object> $class */
        return $class;
    }

    /**
     * Traverse token stack in search of next token.
     *
     * @param list<mixed|array{0: int, 1: string, 2: int}> $tokens
     * @param list<int>                                    $types
     */
    private function findNextToken(array $tokens, array $types, int $start = 0, ?int $escapePreviousType = null): ?int
    {
        $previousToken = false;

        for ($i = $start, $length = \count($tokens); $i < $length; ++$i) {
            $token = $tokens[$i];
            if (!\is_array($token)) {
                continue;
            }

            if (
                \in_array($token[0], $types, true)
                && (
                    $escapePreviousType === null
                    || !\is_array($previousToken)
                    || $previousToken[0] !== $escapePreviousType
                )
            ) {
                return $i;
            }

            $previousToken = $token;
        }

        return null;
    }

    /**
     * @return list<int>
     */
    private function getValidTokenTypes(): array
    {
        return [\T_WHITESPACE, \T_NS_SEPARATOR, \T_STRING, \T_NAME_QUALIFIED];
    }
}
