<?php

namespace Itsmattch\Nexus\Assembler\Builder\Callable\Collection;

use Itsmattch\Nexus\Common\Traits\ArrayHelpers;
use Itsmattch\Nexus\Contract\Assembler\Builder\Callable\Invokable;

/**
 * FilterInvokable provides a way to filter elements from an
 * array based on a specific path within each element.
 */
class FilterInvokable implements Invokable
{
    use ArrayHelpers;

    /**
     * Path within each array element
     * to apply the filter on.
     */
    private readonly string $path;

    /**
     * Stack of filter callbacks to be applied.
     */
    private array $filterStack = [];

    /**
     * @param string $path Path within each
     * array element to apply the filter on.
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * Applies all filters from the stack on the given array.
     *
     * @param array $current The current state of the array.
     * @param array $original The original array.
     *
     * @return array The filtered array.
     */
    public function __invoke(array $current, array $original): array
    {
        if (empty($this->filterStack)) {
            $this->filterStack = [null];
        }

        foreach ($this->filterStack as $filterCallback) {
            $current = array_filter($current, $filterCallback);
        }

        return $current;
    }

    /**
     * Adds a filter to the stack that removes elements where
     * the value at the given path is empty.
     */
    public function notEmpty(): void
    {
        $path = $this->path;
        $this->filterStack[] = function ($value) use ($path) {
            $pathValue = $this->traverseDotArray($path, $value);
            return empty($pathValue);
        };
    }

    /**
     * Adds a filter to the stack that removes elements where
     * the value at the given path is not empty.
     */
    public function empty(): void
    {
        $path = $this->path;
        $this->filterStack[] = function ($value) use ($path) {
            $pathValue = $this->traverseDotArray($path, $value);
            return !empty($pathValue);
        };
    }
}