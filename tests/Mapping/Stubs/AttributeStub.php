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

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class AttributeStub
{
    protected string $name;

    protected ?string $parent;

    public function __construct(string $name, ?string $parent = null)
    {
        $this->name = $name;
        $this->parent = $parent;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getParent(): ?string
    {
        return $this->parent;
    }
}
