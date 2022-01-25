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

namespace Jgut\Mapping\Annotation;

use Jgut\Mapping\Exception\AnnotationException;
use Traversable;
use ReflectionProperty;
use ReflectionClass;

abstract class AbstractAnnotation
{
    /**
     * @param array<mixed>|Traversable|mixed $parameters
     *
     * @throws AnnotationException
     */
    public function __construct($parameters)
    {
        if (!\is_array($parameters) && !$parameters instanceof Traversable) {
            throw new AnnotationException('Parameters must be an iterable.');
        }
        if ($parameters instanceof Traversable) {
            $parameters = iterator_to_array($parameters);
        }

        $configs = array_map(
            static fn (ReflectionProperty $property): string => $property->getName(),
            (new ReflectionClass($this))->getProperties(),
        );

        $unknownParameters = array_diff(array_keys($parameters), $configs);
        if (\count($unknownParameters) > 0) {
            throw new AnnotationException(
                sprintf(
                    'The following annotation parameters are not recognized: %s.',
                    implode(', ', $unknownParameters),
                ),
            );
        }

        foreach ($configs as $config) {
            if (isset($parameters[$config])) {
                /** @var callable $callback */
                $callback = [$this, 'set' . ucfirst($config)];

                $callback($parameters[$config]);
            }
        }
    }
}
