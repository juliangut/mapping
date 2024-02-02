<?php

/*
 * (c) 2017-2024 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/mapping
 */

declare(strict_types=1);

namespace Jgut\Mapping\Tests\Stubs;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class AttributeStub
{
    public function __construct(
        protected string $name,
        protected ?string $parent = null,
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getParent(): ?string
    {
        return $this->parent;
    }
}
