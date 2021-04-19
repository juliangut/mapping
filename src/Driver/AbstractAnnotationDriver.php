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

use Doctrine\Common\Annotations\Reader;

/**
 * Abstract class annotation mapping driver.
 */
abstract class AbstractAnnotationDriver extends AbstractClassDriver
{
    /**
     * Annotations reader.
     *
     * @var Reader
     */
    protected $annotationReader;

    /**
     * AbstractAnnotationDriver constructor.
     *
     * @param string[] $paths
     * @param Reader   $annotationReader
     */
    public function __construct(array $paths, Reader $annotationReader)
    {
        if (\version_compare(\PHP_VERSION, '8.0.0') >= 0) {
            @\trigger_error('Annotation usage is discouraged. Use PHP Attributes instead.', \E_USER_DEPRECATED);
        }

        parent::__construct($paths);

        $this->annotationReader = $annotationReader;
    }
}
