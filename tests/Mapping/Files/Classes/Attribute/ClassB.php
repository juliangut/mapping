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

namespace Jgut\Mapping\Tests\Files\Classes\Attribute;

use Jgut\Mapping\Tests\Stubs\AttributeStub as Stub;

#[Stub(name: 'myClassB')]
/**
 * Dummy class.
 */
class ClassB
{
}
