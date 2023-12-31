<?php

namespace Itsmattch\NexusCore\Assembler\Builder;

use Itsmattch\NexusCore\Assembler\Builder\Callable\Collection\FilterInvokable;
use Itsmattch\NexusCore\Assembler\Builder\Callable\Collection\JoinInvokable;
use Itsmattch\NexusCore\Common\Traits\ArrayHelpers;
use Itsmattch\NexusCore\Contract\Assembler\Builder\CollectionBuilder as CollectionBuilderContract;

class CollectionBuilder extends AssemblerBuilder implements CollectionBuilderContract
{
    use ArrayHelpers;

    public function call(array $array): array
    {
        $workingArray = $array;
        foreach ($this->callableStack as $callable) {
            $workingArray = $callable($workingArray, $array);
        }
        return $workingArray;
    }

    /**
     * Adds a root callable to the callable stack that is
     * responsible for returning a subarray of the original
     * array, specified by a dot notation path.
     *
     * @param string $path Dot notation path to retrieve.
     */
    public function root(string $path): void
    {
        $this->callable(function (array $current, array $original) use ($path): array {
            return $this->traverseDotArray($path, $original);
        });
    }

    /**
     * Creates a new FilterInvokable object, adds it to the
     * callable stack, and returns it, allowing for
     * subsequent configuration of filter conditions.
     *
     * @param string $path Dot notation path in the array to
     * apply filters.
     *
     * @return FilterInvokable The newly created
     * FilterInvokable object.
     */
    public function filter(string $path): FilterInvokable
    {
        $filterInvokable = new FilterInvokable($path);
        $this->callable($filterInvokable);

        return $filterInvokable;
    }

    /**
     * Creates a new JoinInvokable object, adds it to the
     * callable stack, and returns it, allowing for
     * subsequent configuration of join conditions.
     *
     * @param string $path Dot notation path in the array to
     * apply the join.
     *
     * @return JoinInvokable The newly created JoinInvokable
     * object.
     */
    public function join(string $path): JoinInvokable
    {
        $joinInvokable = new JoinInvokable($path);
        $this->callable($joinInvokable);

        return $joinInvokable;
    }
}