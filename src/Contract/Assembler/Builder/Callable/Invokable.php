<?php

namespace Itsmattch\NexusCore\Contract\Assembler\Builder\Callable;

/**
 * The Invokable interface is designed for classes
 * that perform transformations on an array.
 */
interface Invokable
{
    /**
     * Perform a transformation on the current state of
     * array. The exact nature of the transformation is
     * determined by the implementing class.
     *
     * @param array $current The current state of the array.
     * @param array $original The original state of the
     * array, prior to any transformations.
     *
     * @return array The array after the transformation
     * has been applied.
     */
    public function __invoke(array $current, array $original): array;
}