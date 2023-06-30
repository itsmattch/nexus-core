<?php

namespace Itsmattch\Nexus\Contract\Assembler\Builder;

use Closure;
use Itsmattch\Nexus\Contract\Assembler\Builder\Callable\Invokable;

/**
 * Defines a mechanism to build up an array by
 * applying a series of callable transformations.
 */
interface AssemblerBuilder
{
    /**
     * Appends a new callable transformation to the end of
     * the stack. Callable transformations can be either an
     * anonymous function or an object implementing the
     * Invokable interface.
     *
     * @param Closure|Invokable $callable Callable
     * transformation to be applied to the array.
     */
    public function callable(Closure|Invokable $callable): void;

    /**
     * Applies all callable transformations
     * from the stack on the given array.
     *
     * @param array $array The array to apply
     * transformations on.
     *
     * @return array The array after applying all
     * transformations.
     */
    public function call(array $array): array;
}