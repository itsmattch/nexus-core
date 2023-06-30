<?php

namespace Itsmattch\Nexus\Assembler\Builder;

use Itsmattch\Nexus\Assembler\Builder\Callable\Collection\FilterInvokable;
use Itsmattch\Nexus\Assembler\Builder\Callable\Collection\JoinInvokable;
use Itsmattch\Nexus\Common\Traits\ArrayHelpers;
use Itsmattch\Nexus\Contract\Assembler\Builder\CollectionBuilder as CollectionBuilderContract;

/** todo */
class CollectionBuilder extends AssemblerBuilder implements CollectionBuilderContract
{
    use ArrayHelpers;

    /** todo */
    public function root(string $path): void
    {
        $this->callable(function (array $current, array $original) use ($path): array {
            return $this->traverseDotArray($path, $original);
        });
    }

    /** todo */
    public function filter(string $path): FilterInvokable
    {
        $filterInvokable = new FilterInvokable($path);
        $this->callable($filterInvokable);

        return $filterInvokable;
    }

    /** todo */
    public function join(string $path): JoinInvokable
    {
        $joinInvokable = new JoinInvokable($path);
        $this->callable($joinInvokable);

        return $joinInvokable;
    }
}