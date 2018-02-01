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

/**
 * Annotation base.
 */
abstract class AbstractAnnotation
{
    /**
     * Abstract annotation constructor.
     *
     * @param mixed[]|\Traversable $parameters
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($parameters)
    {
        if (!is_iterable($parameters)) {
            throw new \InvalidArgumentException('Parameters must be an iterable');
        }

        $configs = array_keys(get_object_vars($this));

        $unknownParameters = array_diff(array_keys($parameters), $configs);
        if (count($unknownParameters) > 0) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The following annotation parameters are not recognized: %s',
                    implode(', ', $unknownParameters)
                )
            );
        }

        foreach ($configs as $config) {
            if (isset($parameters[$config])) {
                $callback = [$this, 'set' . ucfirst($config)];

                call_user_func($callback, $parameters[$config]);
            }
        }
    }
}
