<?php

/*
 * (c) 2017-2024 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/mapping
 */

declare(strict_types=1);

namespace Jgut\Mapping\Driver;

use Doctrine\Common\Annotations\Reader;

abstract class AbstractAnnotationDriver extends AbstractClassDriver
{
    /**
     * @param list<string> $paths
     */
    public function __construct(
        array $paths,
        protected Reader $annotationReader,
    ) {
        @trigger_error('Annotations are deprecated. Use PHP Attributes instead.', \E_USER_DEPRECATED);

        parent::__construct($paths);
    }
}
