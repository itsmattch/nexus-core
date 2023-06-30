<?php

namespace Itsmattch\Nexus\Assembler\Builder\Callable\Collection;

use Itsmattch\Nexus\Common\Traits\ArrayHelpers;

/** todo */
class FilterInvokable
{
    use ArrayHelpers;

    /** todo */
    private readonly string $path;

    /** todo */
    private array $filterStack = [];

    /** todo */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /** todo */
    public function __invoke(array $current): array
    {
        if (empty($this->filterStack)) {
            $this->filterStack = [null];
        }

        foreach ($this->filterStack as $filterCallback) {
            $current = array_filter($current, $filterCallback);
        }

        return $current;
    }

    /** todo */
    public function notEmpty(): void
    {
        $path = $this->path;
        $this->filterStack[] = function ($value) use ($path) {
            $pathValue = $this->traverseDotArray($path, $value);
            return !empty($pathValue);
        };
    }

    /** todo */
    public function empty(): void
    {
        $path = $this->path;
        $this->filterStack[] = function ($value) use ($path) {
            $pathValue = $this->traverseDotArray($path, $value);
            return empty($pathValue);
        };
    }
}